<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/include.php';

/**
 * Instantiat a new controller
 * and specify endpoints
 */

$Account = new Controller('account');

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
    Controller::required(['email', 'password'], $filteredBody);
    if (AccountModel::create($filteredBody) == 1) {
        return Response::success();
    }
    return Response::err();
});

/**
 * Authenticate account
 * /authenticate - protected by brute force login
 * @param string password
 * Must use one:
 * @param string email - optional
 * @param string username - optional
 */
$Account->post('/authenticate', function ($req) {
    $filteredBody = Controller::filterPayload($req->getBody());
    Controller::required(['password', 'email'], $filteredBody);
    Controller::requireOne(['email', 'username'], $filteredBody);
    $accountExists = AccountModel::getAccountByEmail($filteredBody);
    if (!isset($accountExists['id'])) {
        return Response::err("No account information found. Try creating a new account or using a different email.");
    }
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

// DELETE endpoints

$Account->delete('/accounts/:id', function ($req) { }, TRUE);

$Account->post('/seedAccounts', function ($req) {
    seedAccounts();
    return Response::success();
});
