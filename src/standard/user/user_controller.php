<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/include.php';

/**
 * User
 * 
 *  The user Controller handles
 *  all authentication based actions
 *  that can be performed on user accounts
 *  for the application.
 * 
 *  @todo implement a way to check if the client is loggedin
 *  @todo implement a way to logout and destroy a token
 *  @todo add an action to delete a user
 *  @todo add an action to update user info
 *  @todo add an action to update a user password
 */

$user = new Controller('user');


/**
 * Login User // Passing
 * --------------
 * 
 *  Requires:
 *  @var string userPassword
 *  @var string userEmail
 * 
 * Notes:
 *  @todo Enable $userPasswordCheck in production
 *  @todo do not send password of user to the client
 */
$user->addAction('loginUser', 

  function($payload){

    $filterLoad = Controller::filterPayload($payload, 'userEmail');
                  Controller::required(['userNameOrEmail', 'userPassword'], $filterLoad);

    $isEmail = isEmail($filterLoad['userNameOrEmail']);

    
    if($isEmail) {
      $userEmail = checkEmail($filterLoad['userNameOrEmail']);
      $userData  = get_user_by_email($userEmail);
    } else {
      $userData = get_user_by_name($filterLoad['userNameOrEmail']);
    }
    
    // this ensures that users are creating passwords that contain
    // an uppercase/lowercase/number/symbol in thier passwords
    // $userPasswordCheck = checkPassword($userPassword); 
    $hashCheck = password_verify($filterLoad['userPassword'], $userData['userPassword']);

    // throw error wrong password
    if (!$hashCheck) {
      return Response::err("Your password or username is incorrect.");
      exit;
    }

    // Change user to be online
    // needs more work
    // $updateActivity = update_user_activity(["userIsOnline" => "yes", "userId" => $userData["userId"]]);
    $userData = get_user_by_id($userData['userId']);

    // needs more work
    // if($updateActivity != 1) {
    //   echo "problems with updating user activity";
    //   exit;
    // }
    

    if($GLOBALS['user']->getTokenValidation()) {
      $userData['apiToken'] = generateJWT($userData["userId"]);
    }
    
    return Response::data($userData, 'User successfully logged in.');

});

/**
 * Register User // Passing
 * --------------
 * 
 *  Requires:
 *  @var string userPassword
 *  @var string userEmail
 *  @var string userName
 * 
 * Notes:
 *  @todo Make the registration proccess more verbose and secure
 *  by requireing a captcha or something to ward off crawling
 *  registering malware
 */
$user->addAction('registerUser', 

  function($payload){

    $filteredPayload = Controller::filterPayload($payload);
                      Controller::required(['userName', 'userEmail', 'userPassword'], $payload);

    // Ensure that password and email are valid and clean
    $filteredPayload['userEmail'] = checkEmail($filteredPayload['userEmail']);
    $userEmailVerify = verify_email($filteredPayload['userEmail']);

    // Throw error that entered email address already exists
    if($userEmailVerify){
      return Response::err("An account with that email address already exists please try logging in or using a different email.");
      exit;
    }

    // hash the password before putting it into the database
    $filteredPayload['userPassword'] = password_hash($filteredPayload['userPassword'], PASSWORD_DEFAULT);
    $newRegistrationStatus = register_new_user($filteredPayload);

    // create custom notification that registration was successful
    if($newRegistrationStatus) {
      return Response::success($filteredPayload['userName'] . " account created successfully. Please login to access your account.");
      exit;
    }

});

/**
 * Logout User // Passing
 * --------------
 */

$user->addAction('logoutUser', 

  function($payload){
    $filterLoad = Controller::filterPayload($payload);
                  Controller::required(["userId"], $filterLoad);
    update_user_activity(["userIsOnline" => "no", "userId" => $filterLoad["userId"]]);
    return Response::success("User Logged out successfully");

  }, True);

  /**
   * Delete User // Untested
   * -----------------------
   */

  $user ->addAction('deleteUser', 
  
    function($payload){
      $filterLoad = Controller::filterPayload($payload);
                    Controller::required(["userId"], $filterLoad);
      $deleteUser = delete_user($filterLoad["userId"]);
      if ($deleteUser) {
        return Response::success("User deleted successfully");
      } else {
        return Response::err("User was not deleted successfully");
      }
    }, TRUE);