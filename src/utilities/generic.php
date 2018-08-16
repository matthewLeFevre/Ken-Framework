<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/include.php';

class Generic {

    // request information
    private $reqController;
    private $reqAction;
    private $payload;
    
    // configuration
    private $tokenValidation;
    private $controllers = array();

    function __construct($tokenValidation = FALSE) {
        $this->tokenValidation = $tokenValidation;
    }

    function setTokenValidation($validation) {
        $this->tokenValidation = $validation;
    }
    
    function getTokenValidation() {
        return $this->tokenValidation;
    }

    function getPayload() {
        return $this->payload;
    }

    function addController($controller) {
        // if token validation has been implemented on the server
        // implement it in each controller
        if ($this->tokenValidation) {
            $controller->setTokenValidation($this->tokenValidation);
        }
        $this->controllers[$controller->getName()] = $controller;
    }

    function start() {

        $this->GETListener();
        $this->POSTListener();
        
        echo json_encode($this->proccess());
    }

    function proccess() {
        foreach ($this->controllers as $controller) {
            if($controller->getName() === $this->reqController) {
                return $controller->callAction($this->reqAction, $this->payload);
            }
        }

        response("failure", "The " . $this->reqController . " controller does not exist");
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
                return; 
                exit;
            }

            // A token is not required for the following requests and tokens are not 
            // required --currently-- for any get requests. If request is made for 
            // an aciton other than those in this logic statement a valid token is required.

            // Verify that token validation is used on this server
            if($this->tokenValidation) {
                if ($this->reqAction !== "loginUser" &&
                    $this->reqAction !== "logoutUser" &&
                    $this->reqAction !== "registerUser") {

                    if(isset($this->payload["apiToken"])) {
                        $token = $this->payload["apiToken"];
                        $sanitizedToken = filter_var($token, FILTER_SANITIZE_STRING); // I don't think there is any reason to sanitize the token...
                    } else {
                        echo json_encode(response("failure", "No token was submitted with the request. Please log back in and try again or consult your web administrator."));
                        return exit;
                    }
                }
            }
        } 

        // else {
        //     echo json_encode(response("failure", "Bad post request. Either the controller action or payload was not sent."));
        //     return exit;
        // }
    }

    function GETListener() {
        // GET request Listener
        $this->reqController = filter_input(INPUT_GET, 'controller', FILTER_SANITIZE_STRING);
        $this->reqAction     = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
    }

    function POSTListener() {
        // POST request Listener
        if($this->reqController == NULL || $this->reqAction == NULL){

            // Asset POST Listener
            if(isset($_POST['controller'])) {
                if(!isset($_POST['action'])) {
                    echo(json_encode(response("failure", "The specified controller or action has not been supplied.")));
                    exit;
                } else {
                    $this->reqController = $_POST['controller'];
                    $this->reqAction = $_POST['action'];
                    $this->payload = $_POST;
                }
            }

            // JSON POST Listener
            $json_str = file_get_contents('php://input');

            $this->validateJsonPost($json_str);
        } else {
            // GET payload if not a POST Request
            $this->payload = $_GET;
        }
    }
}
