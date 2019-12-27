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

  public function setParams(array $params)
  {
    $this->params = $params;
  }
}
