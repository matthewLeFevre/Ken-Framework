<?php

namespace KenFramework;

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
  public static function data($data, $msg = "Data Retrieved Successfully", $status = "success")
  {
    http_response_code(200);
    return ["success" => true, "data" => $data, "msg" => $msg];
  }
}
