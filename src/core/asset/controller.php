<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/include.php';

$Asset = new Controller('asset');

$Asset->get('/asset/', function ($payload) {});
$Asset->get('/asset/:id', function ($payload) {});
$Asset->get('/asset/account/:accountId', function ($payload) {});
$Asset->post('/asset', function ($payload) {});
$Asset->put('/asset/:id', function ($payload) {});
$Asset->delete('/asset/:id', function ($payload) {});