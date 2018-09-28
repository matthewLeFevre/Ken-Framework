<?php 

// creates success and failure responses for requests
// to the client side
function response($status, $message) {
  return ["status" => $status, "message" => $message];
}

function errResp($message = "An error was thrown") {
  return ["status" => "failure", "message" => $message];
}

function 

// sends json data responses to the client
function dataResp($status, $data, $message) {
  return ["status"=> $status, "data"=> $data, "message"=>$message];
}

// this will not work with optional inputs need to get rid of this function
function chkEmpty($inputArr) {
  foreach($inputArr as $input) {
    if(empty($input)) {
      return response("failure", "Required data has not been supplied");
      exit;
    }
  }
}

class Response {
  public static function response($status, $message) {
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