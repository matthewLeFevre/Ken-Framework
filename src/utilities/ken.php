<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/include.php';

/**
 * Ken Class
 * 
 *  Here is where the server exists.
 *  The server keeps track of all of the 
 *  controllers and listens for GET and
 *  POST requests. When the requests are
 *  made it pushes the data along to the
 *  right controller and that controller
 *  will fire the correct action.
 * 
 */

class Ken {

    /**
     *  Configuration
     * 
     *  @var boolean $tokenValidation
     *  @var array $controller
     * 
     */
    private $routes = array();
    private $tokenValidation;
    private $routeExemptions = array();

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
    public function __construct($options = ['tokenValidation' => FALSE, 'routeExemptions' => array()]) {
        if(is_bool($options['tokenValidation'])) {
            $this->tokenValidation = $options['tokenValidation'];
        }
        if(!empty($options['routeExemptions'])) {
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

    protected function setTokenValidation($tokenValidation) {
        $this->tokenValidation = $tokenValidation;
    }

    /**
     * isActionExemption()
     * -------------------
     * Checks to see if the action running does not require a token
     */

    private function isActionExemption($reqAction) {
        foreach($this->routeExemptions as $action) {
            if ($action == $reqAction) {
                return TRUE;
            }
        }
    }

    public function getRoutes() {
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

    public function start() {

        foreach($this->routes as $route) {
            $route->setTokenValidation($this->tokenValidation);
        }

        $route = str_replace(
            '/api.php', 
            "", 
            filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_STRING)
        );
        
        $req = new Request(
            $_SERVER['REQUEST_METHOD'], 
            $route, 
            getallheaders(), 
            json_decode(file_get_contents('php://input'), true), 
            $_FILES
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

    function process($req) {
        foreach ($this->routes as $route) {
            if($route->getRoute() == $req->getRoute() && $route->getMethod() == $req->getMethod()) {
                return $route->callRoute($req);
            } 
        }
        return Response::err("The " . $req->getMethod() ." " . $req->getRoute() . " route does not exist");
    }

    public function get($route, $callback, $howToValidate = FALSE) {
        array_push($this->routes, new Route('GET', $route, $callback, $howToValidate));
    }
    public function post($route, $callback, $howToValidate = FALSE) {
        array_push($this->routes, new Route('POST', $route, $callback, $howToValidate));
    }
    public function put($route, $callback, $howToValidate = FALSE) {
        array_push($this->routes, new Route('PUT', $route, $callback, $howToValidate));
    }
    public function patch($route, $callback, $howToValidate = FALSE) {
        array_push($this->routes, new Route('PATCH', $route, $callback, $howToValidate));
    }
    public function delete($route, $callback, $howToValidate = FALSE) {
        array_push($this->routes, new Route('DELETE', $route, $callback, $howToValidate));
    }

    public function integrate(array $routes) {
        $this->routes = array_merge($this->routes, $routes);
    }

}

class Request {
    public function __construct($method, $route, $headers, $body, $file) {
        if(is_array($body) && is_array($file)) {
            $reqBody = array_merge($body, $file);
        } elseif(!isset($file)) {
            $reqBody = $body;
        } elseif(isset($file)) {
            $reqBody = $file;
        } else {
            $reqBody = NULL;
        }

        $params = ltrim($route, '/');
        $params = explode( '/', $params);

        $this->method = $method;
        $this->headers = $headers;
        $this->body = $reqBody;
        $this->params = $params;

        /** 
         *  This is not scalable and only a temporary solution
         *  to remedie complex api endpoints
         * 
         *  @todo  find a dynamic way to work with endpoints
         */ 

        switch(count($params)) {
            case 1:
                $this->route = $route;
                break;
            case 2:
                $this->route = "/$params[0]/:id";
                break;
            case 3: 
                $this->route = "/$params[0]/:id/$params[2]";
                break;
            case 4:
                $this->route = "/$params[0]/:id/$params[2]/:id";
                break;
            default:
                return Response::err("Error analyzing request");
                break;
        }
    }

    public function getRoute() {
        return $this->route;
    }
    public function getBody() {
        return $this->body;
    }
    public function getMethod() {
        return $this->method;
    }
}
