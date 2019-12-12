<?php

namespace KenFramework\Utilities;

use ReallySimpleJWT\Token;

class Route
{
    private $route;
    private $callback;
    private $tokenValidation;
    private $howToValidate;

    public function __construct($method, $route, $callback, $howToValidate = FALSE)
    {
        $this->route = $route;
        $this->callback = $callback;
        $this->howToValidate = $howToValidate;
        $this->method = $method;
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

    public function setTokenValidation($tokenValidation)
    {
        $this->tokenValidation = $tokenValidation;
    }

    /**
     * Getter
     * ---------
     * getName()
     * - retrieves the name of the Action
     */

    public function getRoute()
    {
        return $this->route;
    }

    public function getMethod()
    {
        return $this->method;
    }

    /**
     * __call(string, array) magic method
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

    public function __call($route, $req)
    {
        global $secret;
        // on all actions that require a user to be authenticated adding token validation
        // is a smart idea for the purpose of single page applications.
        if ($this->tokenValidation && $this->howToValidate && !isset($req[0]->headers['Authorization'])) {
            return Response::err("Api token missing, please contact your web administrator");
            exit;
        }
        if ($this->tokenValidation && $this->howToValidate && !Token::validate($req[0]->headers['Authorization'], $secret)) {
            return Response::err("Invalid token sent to api, error encountered in " . $this->route . " action ,please contact your web administrator");
            exit;
        }

        return call_user_func_array($this->callback, $req);
    }
}
