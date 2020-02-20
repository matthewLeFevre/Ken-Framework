<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createMutable(__DIR__ . '/../');
$dotenv->load();
/**
 * Sample Server File
 *
 * This outlines the general structure of the
 * server file.
 */

use KenFramework\Controller;
use KenFramework\Ken;

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

$Routes = new Controller();
$Routes->get("/tests/users", function ($req, $res) {
  return $res->success("This is not the route you want!");
});
$Routes->get("/tests/:id", function ($req, $res) {
  return $res->success("This is the route you want!");
});
$app->integrate($Routes);
$app->start();
