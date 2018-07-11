<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/include.php';

class Controller
{
    public $name;
    public $actions = array();

    function __construct($name) {
        $this->name = $name;
    }

    function getName() {
        return $this->name;
    }

    function addAction($actionName, $actionFunc) {
        $this->actions[$actionName] = new Action($actionName, $actionFunc);
    }

    function callAction($action, $params) {

        foreach ($this->actions as $storedAction) {
            if($storedAction->getName() === $action) {
                return $storedAction->action($params);
                // return $storedAction($params);
            }
        }
        return response("failure", "The specified action has not been defined.");
    }

    function loadAdditionalPayload() {
        
    }
}


// test

$hello = new Controller("hello");

$hello->addAction("world", function($params) {
    $params = "This is what you sent: " . $params;
    return $params;
});


// var_dump($hello);
// exit;

// $hello->callAction("world", "how are you doing");

// add to seperate file
// $user = new Controller("User");
// $user->addAction("loginUser", function($payload) {
//     $userEmail         = filter_var($payload['userEmail']);
//     $userPassword      = filter_var($payload['password'], FILTER_SANITIZE_STRING);
//     $userEmail         = check_email($userEmail);
//     $userPasswordCheck = check_password($userPassword);

//     // throw an error fill in all input fields
//     if(empty($userEmail) || empty($userPassword)) {
//         return response("failure", "Please fill in both your username and password.");
//         exit;
//     }

//     $userData  = get_user_by_email($userEmail);
//     $hashCheck = password_verify($userPassword, $userData['userPassword']);

//     // throw error wrong password
//     if (!$hashCheck) {
//         return response("Your password or username is incorrect.");
//         exit;
//     }

//     $_SESSION['logged_in'] = TRUE;
//     $_SESSION['userData'] = $userData;
//     $_SESSION['userData'] = bin2hex(random_bytes(64));

//     // successfully logedin
//     return dataResp("success", $userData, 'User successfully logged in.');
// });

