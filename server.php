<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/include.php';

// CSRF (cross-site request forgery) vulnerability
// due to serving spa's on seprate local server for 
// development. Remove headers before launching 
// product

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Access-Control-Allow-Methods: GET,POST,PUT,DELETE,OPTIONS");

// first check for a GET request

$controller = filter_input(INPUT_GET, 'controller', FILTER_SANITIZE_STRING);
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);

// second check for a json post request

  if($controller == NULL || $action == NULL){

    if(isset($_POST['controller'])) {
      $controller = $_POST['controller'];
      $action = $_POST['action'];
      $payload = "don't need it";
    }

    $json_str = file_get_contents('php://input');

    if(!empty($json_str)) {
      $reqArr = json_decode($json_str, true);
      
      $action = $reqArr['action'];
      $controller = $reqArr['controller'];
      $payload = $reqArr['payload'];
      
      if( empty($action) || 
          empty($controller)|| 
          empty($payload)){
          echo json_encode(response("failure", "Bad post request. Either the controller action or payload was not sent."));
          exit;
      }

      // A token is not required for the following requests and tokens are not 
      // required --currently-- for any get requests. If request is made for 
      // an aciton other than those in this logic statement a valid token is required.
      if ($action !== "loginUser" &&
          $action !== "logoutUser" &&
          $action !== "registerUser") {

        if(isset($payload["apiToken"])) {
          $token = $payload["apiToken"];
          $sanitizedToken = filter_var($token, FILTER_SANITIZE_STRING);
        } else {
          echo json_encode(response("failure", "No token was submitted with the request. Please log back in and try again or consult your web administrator."));
          exit;
        }

        if( $sanitizedToken !== $_SESSION['userData']['apiToken']) {
          echo json_encode(response("failure", "Invalid token submitted with request. Please consult your web administrator."));
          exit;
        }
      }
    }
  }

  switch ($controller) {
    case "article":
    
      // Check for additional items in query string and add them to payload
      $articleNumber = filter_input(INPUT_GET, 'articleNumber', FILTER_SANITIZE_NUMBER_INT);
      if(isset($articleNumber)) {
        $payload['articleNumber'] = $articleNumber;
      }

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
      echo json_encode(response("failure", "The " . $controller . " controller does not exist"));
    break;
  }