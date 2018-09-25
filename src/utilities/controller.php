<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/include.php';

class Controller
{
    private $name;
    private $actions = array();
    private $tokenValidation;

    public function __construct($name) {
        $this->name = $name;
    }

    /**
     * Setters
     * ---------
     * setTokenValidation(bool)
     * - called when assigned to the server
     *  basically inherits validation from
     *  server configuration by user.
     */

    public function setTokenValidation($validation) {
        $this->tokenValidation = $validation;
        foreach ($this->actions as $storedAction) {
            $storedAction->setTokenValidation($validation);
        }
    }

    /**
     * Getters
     * --------
     * getName()
     * - returns the name of the controller
     * 
     * getTokenValidation()
     * - returns the token validation assigned
     *  it by the server to pass on to controller
     *  actions
     */

    public function getName() {
        return $this->name;
    }

    public function getTokenValidation() {
        return $this->tokenValidation;
    }

    /**
     * addAction(string, function, bool)
     * - instantiates a new action with a name
     * assigns the new action a callback function
     * written by the developer of the controller
     * 
     * - adds the action to its array record of actions
     * 
     * - depending on the action validation can be 
     * supplied to remedy how the aciton should
     * handle token validation.
     */
    public function addAction($actionName, $actionFunc, $howToValidate = FALSE) {
        $this->actions[$actionName] = new Action($actionName, $actionFunc, $howToValidate);
    }

    /**
     * filterPayload(array) static function
     * - used to expedite the filter and sanitize functions
     * only caters to two data types. Strings and Numerics.
     * 
     * **NOTE** - Need a stronger way to deferentiate between 
     * a basic string and input submitted with HTML markup.
     */

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

    /**
     * callAction(string, array)
     *  - iterates over avaliable actions
     * once the correct one is encounted
     * that action is executed and the 
     * parameters for that funcion are sent along
     */

    public function callAction($action, $params) {
        
        foreach ($this->actions as $storedAction) {
            if($storedAction->getName() === $action) {
                return $storedAction->action($params);
            }
        }
        return response("failure", "The specified action has not been defined.");
    }
}