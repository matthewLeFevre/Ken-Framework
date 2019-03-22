<?php 

class Response {
  
  public static function resp($status, $message) {
    return ["status" => $status, "message" => $message];
  }
  public static function success ($message = "Request was successfully executed") {
    return ["status"=>"success", "message"=>$message];
  }
  public static function err($message = "An error was thrown") {
    return ["status" => "failure", "message" => $message];
  }
  public static function data($data, $message = "Data Retrieved Successfully", $status = "success") {
    return ["status"=> $status, "data"=> $data, "message"=>$message];
  }
}