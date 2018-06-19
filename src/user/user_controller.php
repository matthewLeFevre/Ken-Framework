<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/include.php';

function userRequest($action, $payload){

  switch ($action) {
    case 'loginUser':
      $userEmail         = filter_var($payload['userEmail']);
      $userPassword      = filter_var($payload['password'], FILTER_SANITIZE_STRING);
      $userEmail         = check_email($userEmail);
      $userPasswordCheck = check_password($userPassword);

      if(empty($userEmail) || empty($userPassword)) {
        // throw an error fill in all input fields
        $error = "error";
        return $error;
        exit;
      }

      $userData  = get_user_by_email($userEmail);
      $hashCheck = password_verify($userPassword, $userData['userPassword']);

      if (!$hashCheck) {
        // throw error wrong password
        $error = "error";
        return $error;
        exit;
      }

      $_SESSION['loggedin'] = TRUE;
      $_SESSION['userData'] = $userData;

      // successfully logedin
      $success = ['loggedin'=> TRUE, 'status'=>'success', 'userData'=> $userData];
      return $success;
      exit;
    break;

    case 'logoutUser':
      session_destroy();
      $loggedOut = ['loggedin'=> FALSE, 'status'=>'success'];
      return $loggedOut;
    break;

    case 'registerUser':
      // required parameters
      $userName = filter_var($payload['userName'], FILTER_SANITIZE_STRING);
      $userEmail = filter_var($payload['userEmail'], FILTER_SANITIZE_STRING);
      $userPassword = filter_var($payload['userPassword'], FILTER_SANITIZE_STRING);

      // Not required parameters
      $userFirstName = filter_var($payload['userFirstName'], FILTER_SANITIZE_STRING);
      $userLastName = filter_var($payload['userLastName'], FILTER_SANITIZE_STRING);

      // check for empty data entry

      if( empty($userName) ||
          empty($userEmail) ||
          empty($userPassword)) {
        // Throw error that user must enter required data
        // before registering an account
        $error = "error";
        return $error;
        exit;
      }

      // Ensure that password and email are valid and clean
      $userEmail = checkEmail($userEmail);
      $userPasswordCheck = checkPassword($userPassword);

      // Ensure no duplicate emails exist in db when new users register
      $userEmailVerify = verify_email($userEmail);
      if($userEmailVerify){
        // Throw error that entered email address already exists
        $error = "error";
        return $error;
        exit;
      }

      // hash the password before putting it into the database
      $userPassword = password_hash($userPassword, PASSWORD_DEFAULT);
      $newRegistrationStatus = register_new_user($payload);

      if($newRegistrationStatus) {
        // create custom notification that registration was successful
        return $success;
        exit;
      }
    break;

    case 'updateUser':
    break;

    case 'updateUserPassword':
    break;

    default:
    break;
  }

}