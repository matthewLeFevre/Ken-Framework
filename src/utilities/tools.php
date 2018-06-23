<?php 

// creates success and failure responses for post requests
// to the client side
function response($status, $message) {
  return ["status" => $status, "message" => $message];
}

function dataResp($status, $data, $message) {
  return ["status"=> $status, "data"=> $data, "message"=>$message];
}

function chkEmpty($inputArr) {
  foreach($inputArr as $input) {
    return empty($input) ? response("failure", "Required data has not been supplied");
    exit;
  }
}