<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/include.php';

/**
 * Instantiat a new controller
 * and specify endpoints
 */

 $Account = new Controller('account');

 // GET endpoints

 $Account->get('/accounts', function($req) {

 }, TRUE);

 $Account->get('/accounts/:id', function($req) {

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