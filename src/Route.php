<?php

namespace KenFramework;

use ReallySimpleJWT\Token;

class Route
{
    private $route;
    private $callback;
    private $tokenValidation;
    private $howToValidate;
    private $params;

    public function __construct($method, $route, $callback, $howToValidate = FALSE)
    {
        $params = Ken::extractParams($route);
        $this->route = $route;
        $this->params = $params;
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

    public function getParams()
    {
        return $this->params;
    }

    public function getMagicRoute()
    {
        $magicRouteParams = array();
        foreach ($this->params as $par) {
            if (substr($par, 0, 1) === ":") {
                array_push($magicRouteParams, ":wild");
            } else {
                array_push($magicRouteParams, $par);
            }
        }
        return $magicRouteParams;
    }

    /**
     * __call(string, array) magic method
     * reference: http://php.net/manual/en/language.oop5.overloading.php#object.call
     * 
     * - This function executes the user generated function
     *  assigned to this action through the controller
     * 
     * - the method being called is the `$this->callback` 
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

    // Don't forget that $req is a freaking array and you need the first index
    public function __call($route, $req)
    {
        // on all actions that require a user to be authenticated adding token validation
        // is a smart idea for the purpose of single page applications.
        if ($this->tokenValidation && $this->howToValidate && !isset($req[0]->getHeaders()['Authorization'])) {
            echo json_encode(Response::err("Api token missing, please contact your web administrator"));
            exit;
        }
        if ($this->tokenValidation && $this->howToValidate && !Token::validate($req[0]->getHeaders()['Authorization'], $_ENV['KEN_SECRET'])) {
            echo json_encode(Response::err("Invalid token sent to api, error encountered in " . $this->route . " action ,please contact your web administrator"));
            exit;
        }
        $res = new Response();
        return call_user_func_array($this->callback, [$req[0], $res]);
    }
}
