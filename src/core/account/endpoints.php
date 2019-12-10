<?php

use ReallySimpleJWT\Token;
use PHPMailer\PHPMailer\Exception;

$Account = new Account('account');

/**
 * Get all accounts
 * /accounts - admin protected
 */
$Account->get('/accounts', function ($req) {
  Account::checkRole([
    'token' => $req->headers['token'],
    'role' => "admin"
  ]);
  return Response::data(AccountModel::get($req));
}, TRUE);

/**
 * Get account by Id
 * /accounts/:id - admin protected
 * @param int id
 */
$Account->get('/accounts/:id', function ($req) {
  $filteredParams = Controller::filterPayload($req->params);
  Controller::required(['id'], $filteredParams);
  Account::checkRole([
    'token' => $req->headers['token'],
    'role' => "admin"
  ]);
  return Response::data(AccountModel::getOne(['id' => $filteredParams['id']]));
}, TRUE);

/**
 * Create account
 * /accounts - protected w/ captcha
 * @param string email
 * @param string password
 * @param string username - optional
 * 
 * @todo check to see if email is already in use
 * @todo hash password and store the hash
 */
$Account->post('/accounts', function ($req) {
  $filteredBody = Controller::filterPayload($req->getBody());
  Controller::required(['email', 'password', 'name'], $filteredBody);

  if (!Controller::isEmail($filteredBody['email'])) {
    return Response::err("Invalid Email");
  }

  $filteredBody['email'] = Controller::filterEmail($filteredBody['email']);
  $accountData = AccountModel::getByEmail($filteredBody);
  if (isset($accountData['id'])) {
    return Response::err('That email address is already in use. Please try to log in with a current account or try a new email address.');
  }

  $filteredBody['passHash'] = password_hash($filteredBody['password'], PASSWORD_DEFAULT);

  $verificationToken = Token::create(
    $accountData['id'],
    $_ENV['KEN_SECRET'],
    time() + 3600 * 24,
    $_ENV['KEN_DOMAIN']
  );

  global $Account;
  if (AccountModel::create($filteredBody) == 1) {
    try {
      $Account->mail->setFrom('admin@matthew-lefevre.com');
      $Account->mail->addAddress($filteredBody['email']);
      $Account->mail->Subject = "Account created for " . $filteredBody['name'];
      $Account->mail->Body = "<h1>Verify Your account</h1><div><a href='http://site2/api.php/verify?token=$verificationToken'>Verify Account</a></div>";
      $Account->mail->send();
    } catch (Exception $e) {
      return Response::err($e->message);
    }

    return Response::success();
  }

  return Response::err();
});

/**
 * Authenticate account
 * /authenticate - protected by brute force login
 * @param string password
 * @param string email
 */
$Account->post('/authenticate', function ($req) {
  $filteredBody = Controller::filterPayload($req->getBody());
  Controller::required(['password', 'email'], $filteredBody);

  $filteredBody['email'] = Controller::filterEmail($filteredBody['email']);

  $accountData = AccountModel::getByEmail($filteredBody);
  if (!isset($accountData['id'])) {
    return Response::err("No account information found. Try creating a new account or using a different email.");
  }

  Account::checkPass($filteredBody['password'], $accountData['passHash']);

  // Create a new JWT to send back
  $accountAuthData = AccountModel::getAuthData($accountData);
  $accountAuthData["token"] = Token::create(
    $accountData['id'],
    $_ENV['KEN_SECRET'],
    // time() + 3600 * 24 * 7, one week
    // time() + 3600 * 24, one day
    time() + 3600 * 1, // One hour
    $_ENV['KEN_DOMAIN']
  );

  return Response::data($accountAuthData, "Welcome back " . $accountAuthData['name'] . "!");
});

/**
 * keep authenticated
 * /keepAuthenticated - send every 59 minutes or so
 * token is good for one hour
 */
$Account->post('/keepAuthenticated', function ($req) {
  $id = Token::getPayload($req->headers['token'], $_ENV['KEN_SECRET']);
  $token = Token::create(
    $id,
    $_ENV['KEN_SECRET'],
    time() + 3600 * 1, // One Hour
    $_ENV['KEN_DOMAIN']
  );
  return Response::data(['token' => $token], "Account may persist");
}, TRUE);

/**
 * Update account
 * /accounts/:id - admin protected or token protected
 * @param int id
 * @param string email - optional
 * @param string password - optional
 * @param string username - optional
 */
$Account->put('/accounts/:id', function ($req) {
  $filteredParams = Controller::filterPayload($req->params);
  $filteredBody = Controller::filterPayload($req->body);
  Controller::required(['id'], $filteredParams);
  Account::checkId($req->headers['token'], $filteredParams['id']);
  $filteredBody['id'] = (int) $filteredParams['id'];

  if (isset($filteredBody['email'])) {
    Account::checkEmail($filteredBody['email']);
  }

  if (isset($filteredBody['password'])) {
    $filteredBody['passHash'] = password_hash($filteredBody['password'], PASSWORD_DEFAULT);
  }

  if (AccountModel::update($filteredBody) != 1) {
    return Response::err("Account did not update");
  }

  return Response::success("Account updated successfully");
}, TRUE);

/**
 * Reset Password
 * /resetPassword
 * @param password
 */
$Account->put('/accounts/:id', function ($req) { }, TRUE);

// DELETE endpoints

$Account->delete('/accounts/:id', function ($req) {
  $filteredParams = Controller::filterPayload($req->params);
  Controller::required(['id'], $filteredParams);
  Account::checkId($req->headers['token'], $filteredParams['id']);
  if (AccountModel::delete(['id' => $filteredParams['id']]) != 1) {
    return Response::err("Account did not delete");
  }

  return Response::success("Account deleted successfully");
}, TRUE);

$Account->post('/seedAccounts', function ($req) {
  seedAccounts();
  return Response::success();
});

// Verify email account
$Account->get('/verify', function ($req) {
  $id = Token::getPayload($req->params['id'], $_ENV['KEN_SECRET']);
  if (AccountModel::verify(['id' => $id, 'verification' => 'verified']) != 1) {
    return Response::err("Account did not verify correctly");
  }

  return Response::err("Account verified");
});
