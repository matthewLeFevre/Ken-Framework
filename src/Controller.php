<?php

namespace KenFramework;

/**
 * Controller
 * -----------
 * 
 * An extendable class that contains methods
 * that integrate with an instance of the main 
 * ken class.
 */

class Controller
{
    // routes are used to integrate with an instance of the app
    private $routes = array();
    private $routeSegments = array();
    private $pattern = "/[\/:^]([A-z0-9]+)/";

    // http method functions add an endpoint of that type to the routes
    public function get($route, $callback, $howToValidate = FALSE)
    {
        $segments = preg_replace($this->pattern, '', $route);
        $segments = Ken::extractParams($segments);
        array_push($this->routeSegments, $segments);
        array_push($this->routes, new Route('GET', $route, $callback, $howToValidate));
    }
    public function post($route, $callback, $howToValidate = FALSE)
    {
        array_push($this->routes, new Route('POST', $route, $callback, $howToValidate));
    }
    public function put($route, $callback, $howToValidate = FALSE)
    {
        array_push($this->routes, new Route('PUT', $route, $callback, $howToValidate));
    }
    public function patch($route, $callback, $howToValidate = FALSE)
    {
        array_push($this->routes, new Route('PATCH', $route, $callback, $howToValidate));
    }
    public function delete($route, $callback, $howToValidate = FALSE)
    {
        array_push($this->routes, new Route('DELETE', $route, $callback, $howToValidate));
    }

    public function getRoutes()
    {
        return $this->routes;
    }

    public function getRouteSegments()
    {
        return $this->routeSegments;
    }

    /**
     * FilterData
     * 
     * Description:
     * Takes an assosiative array of the body or params of the request
     * or in the params of the request. It is recommended that you 
     * filterData from the request object in the body and params
     * to ensure that data is vetted and clean.
     * 
     * Params:
     *  @param Array $payload
     *  @param Array $exemptions
     */

    public static function filterData($payload, $exemptions = [])
    {
        $cleanData = array();

        foreach ($payload as $key => $value) {
            if (!empty($exemptions)) {
                foreach ($exemptions as $exep) {
                    if ($key === $exep) {
                        $cleanData[$key] = $value;
                    } else {
                        $cleanData[$key] = Self::valueFilter($value);
                    }
                }
            } else {
                $cleanData[$key] = Self::valueFilter($value);
            }
        }
        return $cleanData;
    }

    /**
     * ValueFilter
     * 
     * Description:
     * Determins the type of data passed and applies
     * the correct sanatizing filter. Only filters
     * strings or integers.
     * 
     * Params:
     * @param Any $value
     */

    private static function valueFilter($value)
    {
        switch (gettype($value)) {
            case "integer":
                return filter_var($value, FILTER_SANITIZE_NUMBER_INT);
                break;
            case "string":
                return filter_var($value, FILTER_SANITIZE_STRING);
                break;
            default:
                return NULL;
                break;
        }
    }

    /**
     * Filter Html 
     * ------------
     * 
     * If the client sends html be sure to add an
     * exemption and explicitly fitler the variable
     * with this static function.
     */

    public static function filterHTML($payloadVar)
    {
        if (gettype($payloadVar) == "string") {
            $filterVar = filter_var($payloadVar, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        } else {
            return Response::err("The var to be filtered to HTML was not a string.");
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
    public static function required($inputArr, $payload)
    {
        foreach ($inputArr as $input) {
            if (empty($payload[$input])) {
                echo json_encode(Response::err("$input is required to execute that request and was not found."));
                exit;
            }
        }
    }

    /**
     * requireOne() static function
     * - used to ensure one of the values passed exists
     * @param array required 
     * @param array body
     */
    public static function requireOne($inputArr, $body)
    {
        $oneExists = FALSE;
        foreach ($inputArr as $input) {
            if (isset($body[$input])) {
                if ($oneExists == FALSE) {
                    $oneExists = TRUE;
                } else {
                    echo json_encode(Response::err("More than one value submitted"));
                    exit;
                }
            }
        }

        if ($oneExists == FALSE) {
            echo json_encode(Response::err("A required input was not submitted"));
        }
    }
}
