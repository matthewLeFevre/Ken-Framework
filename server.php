<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/include.php';

// CSRF (cross-site request forgery) vulnerability
// due to serving spa's on seprate local server for 
// development. Remove headers before launching 
// product

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Access-Control-Allow-Methods: GET,POST,PUT,DELETE,OPTIONS");

// Instantiate app
$app = new Generic(TRUE);

// add controllers
$app->addController($asset);
$app->addController($article);
$app->addController($user);

// unused controllers
$app->addController($message);
$app->addController($post);
$app->addController($comment);


// start server
$app->start();