<?php

namespace KenFramework\Utilities;

use PDO;

/**
 * Dispatcher
 * -----------
 * 
 * This dispatcher is currently undergoing
 * testing its function is to make the 
 * previous method of having a function for
 * each model action dynamic
 * 
 * @todo make the dispatch more abstract and less rigid - Options were added
 *       we may need some for of dynamic query builder
 * @todo clean up code so that it looks nicer
 */
class Model
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

  public static function dispatch($sql, $data, $options = ['fetchConstant' => false, 'returnId' => false])
  {
    // parse the sql and find the required fields
    $pattern = "/[:^]([A-z0-9]+)/";
    preg_match_all($pattern, $sql, $matches_out);
    $fields = $matches_out[1];
    $db = dbConnect();
    $stmt = $db->prepare($sql);
    // put in a try catch here
    if (!empty($data)) {
      foreach ($data as $key => $value) {
        foreach ($fields as $field) {
          if ($key == $field) {

            $stmt->bindValue(":$key", $value, self::pdoConstant($value, $key));
          }
        }
      }
    } else {
      return Response::err();
    }
    $stmt->execute();
    if (isset($options['fetchConstant']) && $options['fetchConstant'] != FALSE) {
      $data = "";
      switch ($options['fetchConstant']) {
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

  /**
   * Private function that defines the type of the bound
   * value for storage in the database
   */
  private static function pdoConstant($value, $key)
  {
    switch (gettype($value)) {
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
        $type = gettype($value);
        echo json_encode(Response::err("$key was not of type integer, double, or string. Was type: $type ."));
        exit;
        break;
    }
  }

  /**
   * Optional Columns
   * ----------------
   * 
   * Optional columns returns two strings
   * for respective columns and values in 
   * a dynamically build sql string.
   */
  public static function optionalColumns($options, $payload)
  {
    $columns = "";
    $values = "";
    foreach ($payload as $key => $value) {
      foreach ($options as $opt) {
        if ($key == $opt) {
          $columns .= ", $key";
          $values .= ", :$key";
        }
      }
    }
    return ['columns' => $columns, 'values' => $values];
  }

  /**
   * Optional Update Values
   * ----------------------
   * 
   * Same as optional columns but instead
   * defines a string for updating instead
   * of selecting. Only returns one string.
   */
  public static function optionalUpdateValues($columns, $payload)
  {
    $sql = "";
    foreach ($payload as $key => $value) {
      foreach ($columns as $col) {
        if ($key == $col) {
          $sql .= "$key = :$key,";
        }
      }
    }
    return rtrim($sql, ",");
  }
}
