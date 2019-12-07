<?php

use ReallySimpleJWT\Token;
use PHPMailer\PHPMailer\Exception;

$Account = new Account('account');

/**
 * Get all accounts
 * /accounts - admin protected
 */
$Account->get('/accounts', function ($req) {
  return Response::data(AccountModel::get($req));
}, TRUE);

/**
 * Get account by Id
 * /accounts/:id - admin protected
 * @param int id
 */
$Account->get('/accounts/:id', function ($req) {
  $data = ['account_id' => $req->params['id']];
  return Response::data(AccountModel::getOne($data));
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
  global $Account;
  if (AccountModel::create($filteredBody) == 1) {
    try {
      $Account->mail->setFrom('admin@matthew-lefevre.com');
      $Account->mail->addAddress($filteredBody['email']);
      $Account->mail->Subject = "Account created for " . $filteredBody['name'];
      $Account->mail->Body = "<h1>Verify Your account</h1><div><a href='#'>Verify Account</a></div>";
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

  Controller::checkPass($filteredBody['password'], $accountData['passHash']);

  // Create a new JWT to send back
  $accountAuthData = AccountModel::getAuthData($accountData);
  $accountAuthData["token"] = Token::create(
    $accountData['id'],
    $_ENV['KEN_SECRET'],
    time() + 3600 * 24 * 7,
    $_ENV['KEN_DOMAIN']
  );

  return Response::data($accountAuthData, "Welcome back " . $accountAuthData['name'] . "!");
});

/**
 * Update account
 * /accounts/:id - admin protected or token protected
 * @param int id
 * @param string email - optional
 * @param string password - optional
 * @param string username - optional
 */
$Account->put('/accounts/:id', function ($req) { }, TRUE);

/**
 * Reset Password
 * /resetPassword
 * @param password
 */
$Account->put('/accounts/:id', function ($req) { }, TRUE);

// DELETE endpoints

$Account->delete('/accounts/:id', function ($req) { }, TRUE);

$Account->post('/seedAccounts', function ($req) {
  seedAccounts();
  return Response::success();
});
