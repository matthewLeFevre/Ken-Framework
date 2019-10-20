<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/include.php';

/**
 * Instantiat a new controller
 * and specify endpoints
 */

$Account = new Controller('account');

// GET endpoints

$Account->get('/accounts', function($req) {
    return Response::data(AccountModel::get($req));
}, TRUE);

$Account->get('/accounts/:id', function($req) {
    $data = ['account_id' => $req->params['id']];
    return Response::data(AccountModel::getOne($data));
}, TRUE);

// POST endpoints

$Account->post('/accounts', function($req) {

}, TRUE);

// PUT endpoints

$Account->put('/accounts/:id', function($req) {

}, TRUE);

// DELETE endpoints

$Account->delete('/accounts/:id', function($req) {

}, TRUE);

$Account->post('/seedAccounts', function($req) {
    seedAccounts();
    return Response::success();
});