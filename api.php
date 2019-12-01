<?php

/**
 * Sample Server File
 * 
 * This outlines the general structure of the
 * server file.
 */

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/include.php';

// CSRF (cross-site request forgery) vulnerability
// due to serving spa's on seprate local server for 
// development. Remove headers before launching 
// product

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Access-Control-Allow-Methods: GET,POST,PUT,DELETE,OPTIONS");

// Always returns JSON to the client
header("Content-Type: application/json");

// Instantiate app
$app = new Ken();
$app->integrate($Test->getRoutes());
// $app->integrate($Account->getRoutes());
// var_dump($app->getRoutes());
$app->start();
