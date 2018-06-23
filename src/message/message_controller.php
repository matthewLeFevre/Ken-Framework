<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/include.php';

function messageRequest($action, $payload){
  switch ($action) {
    default:
      return response("failure", "The specified action has not been defined.");
    break;
  }
}