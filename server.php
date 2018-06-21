<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/include.php';

// for some reason i cannot send a resposne that an image was successfully 
// uploaded with out running into a cors (cross origin resource sharing) issue
// I am going have to implement some kind of fix for thsi in the future. 
// untile then I will be allowing access rendering this application vulnerable to 
// CSRF (cross-site request forgery)

header("Access-Control-Allow-Origin: *");

// first check for a GET request

$controller = filter_input(INPUT_GET, 'controller', FILTER_SANITIZE_STRING);
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);

// second check for a json post request

  if($action == NULL){

    $json_str = file_get_contents('php://input');

    if(!empty($json_str)) {
      $reqArr = json_decode($json_str, true);
      $action = $reqArr['action'];
      $controller = $reqArr['controller'];
      $payload = $reqArr['payload'];
      
      if( empty($action) || 
          empty($controller)|| 
          empty($payload)){
        echo postResp("failure", "Bad post request. Either the controller action or payload was not sent.");
        exit;
      } 
    }
    
    // $file = $_FILES['fileUpload'];
    $controller = $_POST['controller'];
    $action = $_POST['action'];
    $payload = "don't need it";
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
      echo json_encode(postResp("failure", "The " . $controller . " controller does not exist"));
    break;
  }