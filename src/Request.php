<?php

namespace KenFramework;

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

    /**
     * This is not scalable and only a temporary solution
     * to remedie complex api endpoints
     *
     * This function is adding id to the end of the param name
     * so id is the only thing that can be passed in a route other
     * than the resource name
     *
     * @todo find a dynamic way to work with endpoints
     */

    // switch (count($params)) {
    //   case 1:
    //     $this->route = $route;
    //     break;
    //   case 2:
    //     $this->route = "/$params[0]/:id";
    //     $this->params['id'] = $this->params[1];
    //     break;
    //   case 3:
    //     $this->route = "/$params[0]/:id/$params[2]";
    //     break;
    //   case 4:
    //     $this->route = "/$params[0]/:id/$params[2]/:id";
    //     break;
    //   default:
    //     return Response::err("Error analyzing request");
    //     break;
    // }
  }

  /**
   * Acceptable routes
   * /item/item/item/:id
   * /item/item/item/:id/item
   */

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
