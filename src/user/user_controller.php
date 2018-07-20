<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/include.php';

$user = new Controller('user');

//===========
// Temporarily disabled the regular expression to check password
// strength, enable and test the regular expression before
// deployment

// Login User -- Retest
$user->addAction('loginUser', function($payload){
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
  if($this->getTokenValidation()) {
    $_SESSION['userData']['apiToken'] = bin2hex(random_bytes(64));
  }

  // successfully logedin
  return dataResp("success", $userData, 'User successfully logged in.');
});

// Logout User -- untested
$user->addAction('logoutUser', function($payload){
  session_destroy();
  // refactor this response
  return dataResp('success', ["action"=> "logout"] , 'You have successfully logged out.');
});

// Register User -- Retest
$user->addAction('registerUser', function($payload){
  $filteredPayload = array();
  // required parameters
  $filteredPayload['userName'] = filter_var($payload['userName'], FILTER_SANITIZE_STRING);
  $filteredPayload['userEmail'] = filter_var($payload['userEmail'], FILTER_SANITIZE_STRING);
  $filteredPayload['userPassword'] = filter_var($payload['userPassword'], FILTER_SANITIZE_STRING);

  // Not required parameters
  if(isset($payload['userFirstName'])) {
    $filteredPayload['userFirstName'] = filter_var($payload['userFirstName'], FILTER_SANITIZE_STRING);
  }

  if(isset($payload['userLastName'])) {
    $filteredPayload['userLastName'] = filter_var($payload['userLastName'], FILTER_SANITIZE_STRING);
  }
  

  // Throw error that user must enter required data
  // before registering an account
  if( empty($filteredPayload['userName']) ||
      empty($filteredPayload['userEmail']) ||
      empty($filteredPayload['userPassword'])) {
    return response("failure", "Please fill in all required data");
    exit;
  }

  // Ensure that password and email are valid and clean
  $filteredPayload['userEmail'] = checkEmail($filteredPayload['userEmail']);
  // $userPasswordCheck = checkPassword($filteredPayload['userPassword']);

  // Ensure no duplicate emails exist in db when new users register
  $userEmailVerify = verify_email($filteredPayload['userEmail']);

  // Throw error that entered email address already exists
  if($userEmailVerify){
    return response("failue", "An account with that email address already exists please try logging in or using a different email.");
    exit;
  }

  // hash the password before putting it into the database
  $filteredPayload['userPassword'] = password_hash($filteredPayload['userPassword'], PASSWORD_DEFAULT);
  $newRegistrationStatus = register_new_user($filteredPayload);

  // create custom notification that registration was successful
  if($newRegistrationStatus) {
    return response("success", filteredPayload['userName'] . " account created successfully. Please login to access your account.");
    exit;
  }
});

// Update User -- unfinished
$user->addAction('updateUser', function($payload){});

// Update User Password -- unfinished
$user->addAction('updateUserPassword', function($payload){});

// Delete -- User
$user->addAction('deleteUser', function($payload){});
