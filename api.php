<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createMutable(__DIR__ . '/');
$dotenv->load();
/**
 * Sample Server File
 *
 * This outlines the general structure of the
 * server file.
 */

use KenFramework\Controller;
use KenFramework\Ken;
use KenFramework\Model;
use KenFramework\Response;

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

class ItemModel extends Model
{
  public static function select()
  {
    return self::dispatch('SELECT * FROM item', null, ['action' => 'fetchAll']);
  }
  public static function insert($data)
  {
    return self::dispatch(
      'INSERT INTO item 
      (color, `name`, `type`) 
      VALUES
      (:color, :name, :type)',
      $data,
      ['id' => true]
    );
  }
  public static function update($data)
  {
    return self::dispatch('', null);
  }
  public static function detlete($data)
  {
    return self::dispatch('', null);
  }
}

$Items = new Controller(['route' => '/items']);
$Items->get("/", function ($req, $res) {
  return $res->data(ItemModel::select(), "Get all items");
});
$Items->post("/", function ($req, $res) {
  $filtBody = Controller::filterData($req->getBody());
  Controller::required(['name'], $filtBody);

  $itemInfo = ItemModel::insert($filtBody);
  if ($itemInfo['rows'] !== 1) {
    return Response::err("Error occured when trying to insert item in db");
  }

  return $res->json($itemInfo, "Item inserted successfully!");
});

$app = new Ken();
$app->integrate($Items);
$app->start();
