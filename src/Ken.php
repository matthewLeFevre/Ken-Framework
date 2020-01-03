<?php

namespace KenFramework;

/**
 * Ken Class
 * 
 * Description:
 * Listens to requests that are made to the server
 * and proccesses them based on http verbs.
 */

class Ken
{

    /**
     *  Configuration
     * 
     *  @var boolean $tokenValidation
     *  @var array $controller
     * 
     */
    private $routes = array();
    private $tokenValidation;

    /**
     *  class constructor
     *  
     *  @param array $options
     * 
     *  @todo explore more configuration options
     *        for the server.
     *  @todo having the options specified like so could pose
     *        issues when all of them are not explicitely used
     */
    public function __construct($options = ['tokenValidation' => FALSE])
    {
        if (is_bool($options['tokenValidation'])) {
            $this->tokenValidation = $options['tokenValidation'];
        }
        if (!empty($options['routeExemptions'])) {
            $this->routeExemptions = $options['routeExemptions'];
        }
    }

    /**
     * Setters
     *-----------------
     * setTokenValidation(boolean) - 
     *
     * if boolean is true token validation will 
     * be required for all protected requests
     *
     * if boolean is false token validation will 
     * never be required.
     *
     *  @param boolean $tokenValidation
     */

    protected function setTokenValidation($tokenValidation)
    {
        $this->tokenValidation = $tokenValidation;
    }

    public function getTokenValidation()
    {
        return $this->tokenValidation;
    }

    public function getRoutes()
    {
        return $this->routes;
    }

    /**
     * start()
     *-----------------
     * - once start is called our server will
     * start listening for GET and POST requests
     *
     * - whenever there is a response to be sent 
     * to the client it comes back to this `echo`
     * function bellow unless there is an error
     * in this class
     */

    public function start()
    {
        foreach ($this->routes as $route) {
            $route->setTokenValidation($this->tokenValidation);
        }

        $route = str_replace(
            '/api.php',
            "",
            filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_STRING)
        );

        $route = explode("?", $route, 2);

        $queryParameters = array();

        parse_str($_SERVER['QUERY_STRING'], $queryParameters);

        $req = new Request(
            $_SERVER['REQUEST_METHOD'],
            $route[0],
            getallheaders(),
            json_decode(file_get_contents('php://input'), true),
            $_FILES,
            $queryParameters
        );

        echo json_encode($this->process($req));
    }

    /**
     * process()
     *------------------------------
     * - When a request is made `process` iterates
     * over each controller and compares the controller
     * name to the controller name specified in the 
     * request.
     *
     * - Once the controller is found the action
     * is then searched for inside of the controller 
     * and executed.
     */

    private function process($req)
    {

        $matchedRoute = $this->matchRoute($req);

        if ($matchedRoute) {
            return $matchedRoute->callRoute($req);
        } else {
            return Response::err("The " . $req->getMethod() . " " . $req->getRoute() . " route does not exist");
        }
    }

    /**
     * @todo change to not only store the routes but also store
     * pieces of route urls that are not dynamic so dynamic
     * variables can be identified.
     */
    public function integrate(array $routes)
    {
        $this->routes = array_merge($this->routes, $routes);
    }

    /**
     * Match Route
     * 
     * Takes in a route and compares it to the route parsed from the request
     * object.
     */

    private function matchRoute($req)
    {
        // get routes with same http method
        $httpMethodRoutes = array();
        foreach ($this->routes as $route) {
            if ($route->getMethod() == $req->getMethod()) {
                array_push($httpMethodRoutes, $route);
            }
        }

        //=========Http Method Routes=============
        $numParamsRoutes = array();
        foreach ($httpMethodRoutes as $route) {
            // var_dump(count($req->getParams()) . " = " . count($route->getParams()));
            if (count($route->getParams()) == count($req->getParams())) {
                array_push($numParamsRoutes, $route);
            }
        }
        //=========Param Count=============
        $numMatchingParamsRoutes = array();
        foreach ($numParamsRoutes as $route) {
            $routeMatches = [
                "numMatches" => 0,
                "route" => $route
            ];
            foreach ($route->getParams() as $param) {
                foreach ($req->getParams() as $reqParam) {
                    if ($param == $reqParam) {
                        $routeMatches['numMatches'] += 1;
                    }
                }
            }
            array_push($numMatchingParamsRoutes, $routeMatches);
        }

        //=========Matching Param Count=============

        $counter = 0;
        $matchedRoute = null;
        foreach ($numMatchingParamsRoutes as $route) {
            if ($route['numMatches'] > $counter) {
                $matchedRoute = $route['route'];
                $counter = $route['numMatches'];
            }
        }

        if ($matchedRoute === null) {
            return false;
        }

        //=========HIghest Matching Param Count=============
        $boundParams = self::bindParams($req, $matchedRoute);
        $req->setParams($boundParams);
        return $matchedRoute;
    }

    /**
     * Bind Params
     * 
     * Identifies the parameters that must be bound
     * and creates a new array with which the route
     * can access params.
     */

    public static function bindParams($req, $matchedRoute)
    {
        $params = array();
        $pattern = "/[:^]([A-z0-9]+)/";
        if (null !== $matchedRoute->getParams()) {
            foreach ($matchedRoute->getParams() as $index => $param) {
                preg_match($pattern, $param, $hits);
                if (count($hits) > 0) {
                    $params[self::trimColon($param)] = $req->getParams()[$index];
                }
            }
        }
        return $params;
    }

    private static function trimColon(string $key)
    {
        return ltrim($key, ":");
    }

    /**
     * Extract params
     * 
     * Takes a route string and converts it to
     * an array to be analyzed more closely
     */

    public static function extractParams($route)
    {
        $params = ltrim($route, '/');
        $params = explode('/', $params);
        return $params;
    }
}
