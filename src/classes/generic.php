<?php

class Generic {

    // request information
    private $reqController
    private $reqAction;
    private $payload;
    
    // configuration
    private $tokenValidation;
    private $controllers = array();

    function __construct($tokenValidation = True) {
        $this->$tokenValidation = $tokenValidation;
    }

    function setTokenValidation($validation) {
        $this->$tokenValidation = $validation;
    }

    function getPayload() {
        return $this->$payload;
    }

    function addController($controller) {
        $this->controllers[$controller->getName()] = $controller;
    }

    function start() {

        // GET request Listener
        $this->reqController = filter_input(INPUT_GET, 'controller', FILTER_SANITIZE_STRING);
        $this->reqAction     = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);

        // POST request Listener
        if($this->controller == NULL || $this->action == NULL){

            // Asset POST Listener
            if(isset($_POST['controller'])) {
                $this->reqController = $_POST['controller'];
                $this->reqAction = $_POST['action'];
                $this->payload = "don't need it";
            }

            // JSON POST Listener
            $json_str = file_get_contents('php://input');

            $this->validateJsonPost($json_str);
        }

        $this->proccess();
    }

    function proccess() {
        for ($controllers as $controller) {
            if($controller->getName() === $this->reqController) {
                echo json_encode($controller->callAction($this->reqAction, $this->payLoad));
                return;
            }
        }

        echo json_encode(response("failure", "The " . $this->reqController . " controller does not exist"));
    }

    function validateJsonPost($json_str) {
        // JSON POST listener has content
        if(!empty($json_str)) {


            $reqArr = json_decode($json_str, true);
            
            $this->reqAction = $reqArr['action'];
            $this->reqController = $reqArr['controller'];
            $this->payload = $reqArr['payload'];
            
            if( empty($this->reqAction) || 
                empty($this->reqController)|| 
                empty($this->payload)){
                echo json_encode(response("failure", "Bad post request. Either the controller action or payload was not sent."));
                return exit;
            }

            // A token is not required for the following requests and tokens are not 
            // required --currently-- for any get requests. If request is made for 
            // an aciton other than those in this logic statement a valid token is required.

            // Verify that token validation is used on this server
            $this->setTokenValidation ? true : return;

            if ($this->reqAction !== "loginUser" &&
                $this->reqAction !== "logoutUser" &&
                $this->reqAction !== "registerUser") {

                if(isset($this->payload["apiToken"])) {
                    $token = $this->payload["apiToken"];
                    $sanitizedToken = filter_var($token, FILTER_SANITIZE_STRING);
                } else {
                    echo json_encode(response("failure", "No token was submitted with the request. Please log back in and try again or consult your web administrator."));
                    return exit;
                }

                if( $sanitizedToken !== $_SESSION['userData']['apiToken']) {
                    echo json_encode(response("failure", "Invalid token submitted with request. Please consult your web administrator."));
                    return exit;
                }
            }
        }
    }

}

// example setup

// add to server file
$app = new Generic;
    //-- add controllers
    $app->addController($user);
    //-- listen for and proccess requests
    $app->start();



// add to seperate file
$user = new Controller("User");
$user->addAction("loginUser", function($payload) {
    $userEmail         = filter_var($payload['userEmail']);
    $userPassword      = filter_var($payload['password'], FILTER_SANITIZE_STRING);
    $userEmail         = check_email($userEmail);
    $userPasswordCheck = check_password($userPassword);

    // throw an error fill in all input fields
    if(empty($userEmail) || empty($userPassword)) {
        return response("failure", "Please fill in both your username and password.");
        exit;
    }

    $userData  = get_user_by_email($userEmail);
    $hashCheck = password_verify($userPassword, $userData['userPassword']);

    // throw error wrong password
    if (!$hashCheck) {
        return response("Your password or username is incorrect.");
        exit;
    }

    $_SESSION['logged_in'] = TRUE;
    $_SESSION['userData'] = $userData;
    $_SESSION['userData'] = bin2hex(random_bytes(64));

    // successfully logedin
    return dataResp("success", $userData, 'User successfully logged in.');
});

$response = $user->callAction("loginUser", $app->getPayload());
echo json_encode($response);