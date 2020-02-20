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
  private $routeSegments = array();

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

    // In the event that a request is made with an extra
    // slash it will be removed to match correct route
    rtrim($route[0], "/");

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
      if ($req->getMethod() == "OPTIONS") {
        return Response::success("You made a preflight response. Welcome to a Ken Server :D");
      } else {
        return Response::err("The " . $req->getMethod() . " " . $req->getRoute() . " route does not exist");
      }
    }
  }

  /**
   * @todo change to not only store the routes but also store
   * pieces of route urls that are not dynamic so dynamic
   * variables can be identified and routes can be matched
   * exactly.
   */
  public function integrate(Controller $controller)
  {
    // 1. loop through routes
    $this->routes = array_merge($this->routes, $controller->getRoutes());
    // 2. loop through route segments and look for matches if no
    //    match is found add the segment to the list
    $routeSegments = $controller->getRouteSegments();
    foreach ($routeSegments as $segment) {
      $doNotAdd = false;
      foreach ($this->routeSegments as $seg) {
        if ($segment === $seg) {
          $doNotAdd = TRUE;
        }
      }
      if (!$doNotAdd) {
        array_push($this->routeSegments, $segment);
      } else {
        $doNotAdd = TRUE;
      }
    }
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
    $matchedRoute = null;
    foreach ($this->routes as $route) {
      if ($route->getMethod() == $req->getMethod()) {
        $magicRouteReq = $this->condenseParams($req->getMagicRoute($this->routeSegments));
        $magicRoute = $this->condenseParams($route->getMagicRoute());
        if ($magicRouteReq === $magicRoute) {
          $boundParams = self::bindParams($req, $route);
          $req->setParams($boundParams);
          $matchedRoute = $route;
        }
      }
    }

    if ($matchedRoute === null) {
      return false;
    } else {
      return $matchedRoute;
    }
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

  /**
   * Condense params
   * 
   * Takes an array of params and condenses them
   * into a route string
   */
  public static function condenseParams($params)
  {
    $route = "";
    foreach ($params as $par) {
      $route .= "/$par";
    }
    return $route;
  }
}
