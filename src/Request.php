<?php

namespace KenFramework;

/**
 * Request Data
 * -------------
 * 
 * A class that contains all the useful
 * information sent from the client in a 
 * request.
 */

class Request
{
  // Changing public to private for backwards compatability
  public $method;
  public $headers;
  public $body;
  public $params;
  public $queryString;
  public $route;

  public function __construct($method, $route, $headers, $body, $file, $queryString = null)
  {
    if (is_array($body) && is_array($file)) {
      $reqBody = array_merge($body, $file);
    } elseif (!isset($file)) {
      $reqBody = $body;
    } elseif (isset($file)) {
      $reqBody = $file;
    } else {
      $reqBody = NULL;
    }

    $params = Ken::extractParams($route);

    $this->method = $method;
    $this->headers = $headers;
    $this->body = $reqBody;
    $this->params = $params;
    $this->queryString = $queryString;
    $this->route = $route;
  }

  public function getRoute()
  {
    return $this->route;
  }
  public function getBody()
  {
    return $this->body;
  }
  public function getMethod()
  {
    return $this->method;
  }
  public function getParams()
  {
    return $this->params;
  }
  public function getHeaders()
  {
    return $this->headers;
  }
  public function getQueryString()
  {
    return $this->queryString;
  }

  public function setParams(array $params)
  {
    $this->params = $params;
  }

  /**
   * Get Magic Route
   * 
   * Takes all of the parameters of the route
   * and compares them to all of the segments
   * it then reconstructs the route and applies
   * :wild to where the dynamic variables are
   * it then returns this string for comparison
   */
  public function getMagicRoute($segments)
  {
    $magicRouteParams = array();
    foreach ($this->params as $par) {
      $found = false;
      foreach ($segments as $seg) {
        if ($par === $seg) {
          $found = TRUE;
          break;
        }
      }
      if ($found) {
        array_push($magicRouteParams, $par);
        $found = FALSE;
      } else {
        array_push($magicRouteParams, ":wild");
      }
    }
    return $magicRouteParams;
  }
}
