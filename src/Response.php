<?php

namespace KenFramework;

class Response
{
  public static function resp($status, $message, $code = 200)
  {
    http_response_code($code);
    return ["success" => $status, "message" => $message];
  }
  public static function success($message = "Request was successfully executed")
  {
    http_response_code(200);
    return ["success" => true, "message" => $message];
  }
  public static function err($message = "An error was thrown")
  {
    http_response_code(400);
    return ["success" => false, "message" => $message];
  }
  public static function data($data, $message = "Data Retrieved Successfully", $status = "success")
  {
    http_response_code(200);
    return ["success" => true, "data" => $data, "message" => $message];
  }
}
