<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/include.php';

class Controller
{
    private $name;
    private $actions = array();
    private $tokenValidation;

    function __construct($name) {
        $this->name = $name;
    }

    function getName() {
        return $this->name;
    }

    function setTokenValidation($validation) {
        $this->tokenValidation = $validation;
        foreach ($this->actions as $storedAction) {
            $storedAction->setTokenValidation($validation);
        }
    }

    function getTokenValidation() {
        return $this->tokenValidation;
    }

    function addAction($actionName, $actionFunc, $howToValidate = FALSE) {
        $this->actions[$actionName] = new Action($actionName, $actionFunc, $howToValidate);
    }

    public static function filterPayload($payload) {
        $filteredPayload = array();
        foreach($payload as $key => $load) {
            switch(gettype($load)) {
                case "integer":
                $filter = filter_var($load, FILTER_SANITIZE_NUMBER_INT);
                break;
                case "string":
                    if(strlen($load) > 45) {
                        $filter = filter_var($load, FILTER_SANITIZE_STRING);
                    } else {
                        $filter = filter_var($load,   FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    }
                break;
                default:
                $filter = NULL;
                break;
            }
            $filteredPayload[$key] = $filter;
        }
        return $filteredPayload;
    }

    function callAction($action, $params) {
        
        foreach ($this->actions as $storedAction) {
            if($storedAction->getName() === $action) {
                return $storedAction->action($params);
            }
        }
        return response("failure", "The specified action has not been defined.");
    }
}