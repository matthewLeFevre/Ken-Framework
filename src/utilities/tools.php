<?php 

// creates success and failure responses for requests
// to the client side
function response($status, $message) {
  return ["status" => $status, "message" => $message];
}

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