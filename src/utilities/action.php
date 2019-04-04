<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/include.php';

class Action
{
    private $name;
    private $action;
    private $tokenValidation;
    private $howToValidate;

    public function __construct($name, $action, $validation) {
        $this->name = $name;
        $this->action = $action;
        $this->howToValidate = $validation;
    }

    /**
     * Setter
     * ----------
     * setTokenValidation($boolean)
     * - when Action is instansiated by
     * a constructor it recieves token validation
     * 
     *  @param boolean $tokenValidation
     */

    public function setTokenValidation($tokenValidation) {
        $this->tokenValidation = $tokenValidation;
    }

    /**
     * Getter
     * ---------
     * getName()
     * - retrieves the name of the Action
     */

    public function getName() {
        return $this->name;
    }

    /**
     * __call(string, array) majic method
     * reference: http://php.net/manual/en/language.oop5.overloading.php#object.call
     * 
     * - This function executes the user generated function
     *  assigned to this action through the controller
     * 
     * - the method being called is the `$this->action` 
     * method that was assigned to this aciton object
     * at the point of instantiation.
     * 
     * call_user_func_array(function, parameters)
     * reference: http://php.net/manual/en/function.call-user-func-array.php
     * 
     * - calls a callback function. The calback function
     *  called is the one given to the action when 
     *  it is first instantiated by the contructor.
     * 
     * @param string $name
     * @param array $arguments
     */

    public function __call($name, $arguments) {
        // on all actions that require a user to be authenticated adding token validation
        // is a smart idea for the purpose of single page applications.
        if($this->tokenValidation && $this->howToValidate && !isset($arguments[0]['apiToken'])) {
            return Response::err("Api token missing, please contact your web administrator");
            exit;
        }
        if($this->tokenValidation && $this->howToValidate && !verifyToken($arguments[0]['apiToken'])) {
            return Response::err("Invalid token sent to api, error encountered in ". $this->name." action ,please contact your web administrator");
            exit;
        }
        return call_user_func_array($this->action, $arguments);
    }
}