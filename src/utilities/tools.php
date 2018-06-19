<?php 

// creates success and failure responses for post requests
// to the client side
function postResp($status, $message) {
  return ["status" => $status, "message" => $message];
}