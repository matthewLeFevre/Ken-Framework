<?php 

class Response {
  public static function resp($status, $message, $code = 200) {
    http_response_code($code);
    return ["status" => $status, "message" => $message];
  }
  public static function success ($message = "Request was successfully executed") {
    http_response_code(200);
    return ["status"=>"success", "message"=>$message];
  }
  public static function err($message = "An error was thrown") {
    http_response_code(400);
    return ["status" => "failure", "message" => $message];
  }
  public static function data($data, $message = "Data Retrieved Successfully", $status = "success") {
    http_response_code(200);
    return ["status"=> $status, "data"=> $data, "message"=>$message];
  }
}