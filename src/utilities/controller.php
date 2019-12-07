<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/include.php';

class Controller
{
    private $routes = array();

    public function get($route, $callback, $howToValidate = FALSE)
    {
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


    /**
     * filterPayload(array) static function
     * - used to expedite the filter and sanitize functions
     * only caters to two data types. Strings and Numerics.
     * 
     * @param array $payload
     * @param array $exemptions
     */

    public static function filterPayload($payload, $exemptions = [])
    {
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
         * 
         * @todo this needs to be refactored to be dry
         */
        foreach ($payload as $key => $value) {
            if (!empty($exemptions)) {
                foreach ($exemptions as $exep) {
                    if ($key === $exep) {
                        $filterLoad[$key] = $value;
                    } else {
                        $filterLoad[$key] = Self::valueFilter($value);
                    }
                }
            } else {
                $filterLoad[$key] = Self::valueFilter($value);
            }
        }
        return $filterLoad;
    }

    /**
     * valueFilter($value) - utility function for
     * - used in filter payload.
     */
    public static function valueFilter($value)
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
     * Filter Text
     * -------------
     * 
     * If the client has sent a variable that is 
     * a string you can filter and sanitize it
     * with this function.
     */
    public static function filterText($payloadVar)
    {
        if (gettype($payloadVar) == "string") {
            $filterVar = filter_var($payloadVar, FILTER_SANITIZE_STRING);
        } else {
            return Response::err("The var to be filtered to plain text was not a string.");
        }

        return $filterVar;
    }

    /**
     * Filter Email
     * ------------
     * 
     * If the client has sent an email
     * sanitize and filter it with with command. 
     */

    public static function filterEmail($email)
    {
        $sanEmail = filter_var($email, FILTER_SANITIZE_EMAIL);
        $valEmail = filter_var($sanEmail, FILTER_VALIDATE_EMAIL);
        return $valEmail;
    }

    /**
     * Is Email
     * ---------
     * 
     * Returns a boolean that reflects whether
     * or not a string is an email. This can
     * very easily be tricked in its current state.
     * 
     * @todo make more reliable with regex
     */

    public static function isEmail($input)
    {
        $key = stripos($input, '@');
        if ($key) {
            return true;
        } else {
            return false;
        }
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
