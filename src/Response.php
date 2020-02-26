<?php

namespace KenFramework;

/**
 * Response
 * --------
 * 
 * The most common methods to respond to
 * client requests.
 * 
 * 1. Custom response
 * 2. Success response
 * 3. Error response
 * 4. Data payload response
 */
class Response
{
  public static function resp($status, $msg, $code = 200)
  {
    http_response_code($code);
    return ["success" => $status, "msg" => $msg];
  }
  public static function success($msg = "Request was successfully executed")
  {
    http_response_code(200);
    return ["success" => true, "msg" => $msg];
  }
  public static function err($msg = "An error was thrown")
  {
    http_response_code(400);
    return ["success" => false, "msg" => $msg];
  }
  public static function json($data, $msg = "Data Retrieved Successfully", $status = "success")
  {
    http_response_code(200);
    return ["success" => $status, "data" => $data, "msg" => $msg];
  }
  // for backwards compatability
  public static function data($data, $msg = "Data Retrieved Successfully", $status = "success")
  {
    http_response_code(200);
    return ["success" => $status, "data" => $data, "msg" => $msg];
  }
}
