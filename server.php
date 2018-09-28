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
$app = new Generic();

// add controllers
$app->addController($asset);
$app->addController($article);
$app->addController($user);

// custom module controllers in development
$app->addController($project);
$app->addController($styleGuide);
$app->addController($section);

// start server
$app->start();