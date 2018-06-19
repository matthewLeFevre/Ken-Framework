<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/include.php';

// first check for a GET request

$controller = filter_input(INPUT_GET, 'controller', FILTER_SANITIZE_STRING);
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);

// second check for a json post request

  if($action == NULL){

    $json_str = file_get_contents('php://input');
    $reqArr = json_decode($json_str, true);

    $action = $reqArr['action'];
    $controller = $reqArr['controller'];
    $payload = $reqArr['payload'];
    
    if( empty($action) || 
        empty($controller)|| 
        empty($payload)){
      
      $error = ["status"=> "failure", "message" => "Bad post request. Either the controller action or payload was not sent."];
      echo json_encode($error);
      exit;
    } 

  }

  switch ($controller) {
    case "article":
      echo json_encode(articleRequest($action, $payload));
    break;
    case "asset":
      echo json_encode(assetRequest($action, $payload));
    break;
    case "comment":
      echo json_encode(commentRequest($action, $payload));
    break;
    case "message":
      echo json_encode(messageRequest($action, $payload));
    break;
    case "post":
      echo json_encode(postRequest($action, $payload));
    break;
    case "user":
      echo json_encode(userRequest($action, $payload));
    break;
    default: 
      echo json_encode($error = ["status"=>"failure", "message"=>"requested controller does not exist"]);
    break;
  }