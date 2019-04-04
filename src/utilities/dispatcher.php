<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/include.php';

/**
 * Dispatcher
 * -----------
 * 
 * This dispatcher is currently undergoing
 * testing its function is to make the 
 * previous method of having a function for
 * each model action dynamic
 * 
 * @todo test the dispatcher against more actions
 */

class Dispatcher 
{

  function __construct($table, $fields) {
    $this->table = $table;
    $this->fields = $fields;
  }

  /**
   * Specify details that the dispatch can 
   * execute against the database.
   * 
   * Iterates over each key and binds the
   * value to the PDO object.
   * 
   * @param string $sql
   * @param array $data
   * @param string $fetchConstant
   */
  
  public function dispatch($sql, $data, $fetchConstant = false) {
    $db = dbConnect();
    $stmt = $db->prepare($sql);

    foreach($data AS $key => $value) {
      foreach($this->fields AS $field) {
        if($key == $field) {
          $stmt->bindValue(":$key", $value, $this->pdoConstant($value, $key));
        }
      }
    }

    $stmt->execute();

    if($fetchConstant) {
      $data = "";
      switch($fetchConstant) {
        case "fetch":
          $data = $stmt->fetch(PDO::FETCH_NAMED);
          break;
        case "fetchAll":
          $data = $stmt->fetchAll(PDO::FETCH_NAMED);
          break;
        case "fetchNum":
          $data = $stmt->fetch(PDO::FETCH_NUM);
          break;
        default:
          return Response::err("Options were not legally set.");
          break;
      }
      $stmt->closeCursor();
      return $data;
    } else {
      $rowsChanged = $stmt->rowCount();
      $stmt->closeCursor();
      return $rowsChanged;
    }
  }

  private function pdoConstant($value, $key) {
    switch(gettype($value)) {
      case 'string':
        return PDO::PARAM_STR;
      break;
      case 'integer':
        return PDO::PARAM_INT;
      break;
      case 'double':
        return PDO::PARAM_INT;
      break;
      default:
        return Response::err("$key was not of type integer, double, or string.");
      break;
    }
  }

}