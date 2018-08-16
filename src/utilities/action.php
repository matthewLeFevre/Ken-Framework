<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/include.php';

class Action
{
    private $name;
    private $action;
    private $tokenValidation;
    private $howToValidate;

    function __construct($name, $action, $validation) {
        $this->name = $name;
        $this->action = $action;
        $this->howToValidate = $validation;
    }

    function setTokenValidation($tokenValidation) {
        $this->tokenValidation = $tokenValidation;
    }

    function getName() {
        return $this->name;
    }

    function __call($name, $arguments) {
        // on all actions that require a user to be authenticated adding token validation
        // is a smart idea for the purpose of single page applications.
        if($this->tokenValidation && $this->howToValidate && !isset($arguments[0]['apiToken'])) {
            return response("failure", "Api token missing, please contact your web administrator");
            exit;
        }
        if($this->tokenValidation && $this->howToValidate && !verifyToken($arguments[0]['apiToken'])) {
            return response("failure", "Invalid token sent to api, error encountered in ". $this->name." action ,please contact your web administrator");
            exit;
        }
        return call_user_func_array($this->action, $arguments);
    }
}