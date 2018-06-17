<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/include.php';

$controller = filter_input(INPUT_GET, 'controller');
$action = filter_input(INPUT_GET, 'action');

  if($action == NULL){
    $payload = file_get_contents('php://input');
    $payloadPHP = json_decode($payload, true);
    $action = $payloadPHP['action'];
    if($action == NULL){
      $action = 'null';
    }
  }