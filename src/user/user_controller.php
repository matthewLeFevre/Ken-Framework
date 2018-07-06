<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/include.php';

function userRequest($action, $payload){

  switch ($action) {
    case 'loginUser':
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

      $_SESSION['loggedin'] = TRUE;
      $_SESSION['userData'] = $userData;

      // successfully logedin
      return dataResp("success", $userData, 'User successfully logged in.');
      exit;
    break;

    case 'logoutUser':
      session_destroy();
      $loggedOut = ['loggedin'=> FALSE, 'status'=>'success'];
      // refactor this response
      return loginResp(FALSE, null, 'success');
    break;

    case 'registerUser':
      $filteredPayload = array();
      // required parameters
      $filteredPayload['userName'] = filter_var($payload['userName'], FILTER_SANITIZE_STRING);
      $filteredPayload['userEmail'] = filter_var($payload['userEmail'], FILTER_SANITIZE_STRING);
      $filteredPayload['userPassword'] = filter_var($payload['userPassword'], FILTER_SANITIZE_STRING);

      // Not required parameters
      $filteredPayload['userFirstName'] = filter_var($payload['userFirstName'], FILTER_SANITIZE_STRING);
      $filteredPayload['userLastName'] = filter_var($payload['userLastName'], FILTER_SANITIZE_STRING);

      // Throw error that user must enter required data
      // before registering an account
      if( empty($filteredPayload['userName']) ||
          empty($userEmail) ||
          empty($userPassword)) {
        return response("failure", "Please fill in all required data");
        exit;
      }

      // Ensure that password and email are valid and clean
      $filteredPayload['userEmail'] = checkEmail($filteredPayload['userEmail']);
      $userPasswordCheck = checkPassword($filteredPayload['userPassword']);

      // Ensure no duplicate emails exist in db when new users register
      $userEmailVerify = verify_email($filteredPayload['userEmail']);

      // Throw error that entered email address already exists
      if($userEmailVerify){
        return response("failue", "An account with that email address already exists please try logging in or using a different email.");
        exit;
      }

      // hash the password before putting it into the database
      $userPassword = password_hash($userPassword, PASSWORD_DEFAULT);
      $newRegistrationStatus = register_new_user($filteredPayload);

      // create custom notification that registration was successful
      if($newRegistrationStatus) {
        return response("success", "Account created successfully. Please login to access your account.");
        exit;
      }
    break;

    case 'updateUser':
    break;

    case 'updateUserPassword':
    break;

    default:
      return response("failure", "The specified action has not been defined.");
    break;
  }

}