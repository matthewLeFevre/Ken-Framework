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
 * @todo test the dispatcher against more actions - testing is underway
 * @todo make the dispatch more abstract and less rigid - Options were added
 *       we may need some for of dynamic query builder
 * @todo clean up code so that it looks nicer
 */
class Dispatcher 
{
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
   * 
   * @todo Provide documentation and descriptions for all methods
   */
  
  public static function dispatch($sql, $data, $options = ['fetchConstant' => false, 'returnId' => false]) {
    $fields = array();
    // parse the sql and find the required fields
    // $pattern = "/[:^](\S*)[$,|$)]/";
    // $pattern = "/[:^](\S+)/";
    $pattern = "/[:^]([A-z]+)/";
    preg_match_all($pattern, $sql, $matches_out);
    $fields = $matches_out[1];
    $db = dbConnect();
    $stmt = $db->prepare($sql);
    // put in a try catch here
    if(!empty($data)) { 
      foreach($data AS $key => $value) {
        foreach($fields AS $field) {
          if($key == $field) {
            
            $stmt->bindValue(":$key", $value, self::pdoConstant($value, $key));
          }
        }
      }
    } else {
      return Response::err();
    }
    $stmt->execute();
    if(isset($options['fetchConstant']) && $options['fetchConstant'] != FALSE) {
      $data = "";
      switch($options['fetchConstant']) {
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
      if (isset($options['returnId']) && $options['returnId'] == TRUE) {
        $id = $db->lastInsertId();
        $stmt->closeCursor();
        return ["rows" => $rowsChanged, "id" => $id];
      }
      $stmt->closeCursor();
      return $rowsChanged;
    }
  }
  private static function pdoConstant($value, $key) {
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