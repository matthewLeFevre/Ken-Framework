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
     * 
     * @param boolean $validation
     */

    public function setTokenValidation($validation) {
        $this->tokenValidation = $validation;
        foreach ($this->actions as $storedAction) {
            $storedAction->setTokenValidation($validation);
        }
    }

    /**
     * Get-ers
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
     * 
     * @param string $actionName
     * @param function $actionFunc
     * @param boolean $howToValidate
     */
    public function addAction($actionName, $actionFunc, $howToValidate = FALSE) {
        $this->actions[$actionName] = new Action($actionName, $actionFunc, $howToValidate);
    }

    /**
     * filterPayload(array) static function
     * - used to expedite the filter and sanitize functions
     * only caters to two data types. Strings and Numerics.
     * 
     * @param array $payload
     * @param array $exemptions
     */

    public static function filterPayload($payload, $exemptions = []) {
        $filterLoad = array();

        /**
         * Iterate through the payload
         * ---------------------------
         * 
         * If there are exemptions that are specified
         * iterate through all of the exemptions and 
         * compate them to the key of each payload
         * if there is a match assign that value 
         * to the payload without being sanitized.
         */
        foreach($payload as $key => $value) {
            if(!empty($exemptions)) {
                foreach($exemptions as $exep) {
                    if($key === $exep) {
                        $filterLoad[$key] = $value;
                    }
                }
            } else {
                switch(gettype($value)) {
                    case "integer":
                        $filter = filter_var($value, FILTER_SANITIZE_NUMBER_INT);
                        break;
                    case "string":
                        $filter = filter_var($value, FILTER_SANITIZE_STRING);
                        break;
                    default:
                        $filter = NULL;
                        break;
                }
                $filterLoad[$key] = $filter;
            }
        }
        return $filterLoad;
    }

    /**
     * Filter Html 
     * ------------
     * 
     * If the client sends html be sure to add an
     * exemption and explicitly fitler the variable
     * with this static function.
     */

    public static function filterHTML($payloadVar) {
        if(gettype($payloadVar) == "string") {
            $filterVar = filter_var($payloadVar, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        } else {
            return Response::err("The var to be filtered to HTML was not a string.");
        }

        return $filterVar;
    }

    public static function filterText($payloadVar) {
        if(gettype($payloadVar) == "string") {
            $filterVar = filter_var($payloadVar, FILTER_SANITIZE_STRING);
        } else {
            return Response::err("The var to be filtered to plain text was not a string.");
        }

        return $filterVar;
    }

    /**
     * required(array, array) static funciton
     * - used to quickly check if inputs sent in the
     * filtered request are present and not empty.
     * 
     * -only configure checkInputs that are required
     * for the action to be completed.
     */

    public static function required($inputArr, $payload) {
        foreach($inputArr as $input) {
            if(empty($payload[$input])) {
                echo json_encode(Response::err("$input is required to execute that request and was not found."));
                exit;
            }
        }
    }

    /**
     * callAction(string, array)
     *  - iterates over avaliable actions
     * once the correct one is encounted
     * that action is executed and the 
     * parameters for that funcion are sent along
     * 
     * @param string $action
     * @param array $params
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