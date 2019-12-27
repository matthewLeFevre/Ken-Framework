<?php

namespace KenFramework;

use PDO;
use PDOException;

class Model
{
  /**
   * Database Connect
   * ----------------
   * 
   * Connects to the database configured by the enviornment variables.
   */
  protected static function dbConnect()
  {
    $server = $_ENV['KEN_SERVER'];
    $database = $_ENV['KEN_DB'];
    $user = $_ENV['KEN_DB_USER'];
    $password = $_ENV['KEN_DB_PASSWORD'];
    $dsn = "mysql:host=$server; dbname=$database";
    $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
    try {
      $genericLink = new PDO($dsn, $user, $password, $options);
      return $genericLink;
    } catch (PDOException $ex) {
      echo $ex;
      exit;
    }
  }

  /**
   * Dispatch
   * --------
   * 
   * Connects to the database and analyzes an 
   * SQL string for dynamic variables. Binds 
   * dynamic variables and executes the query.
   * Evaluates options and returns rowcount of
   * affected records and or new record id.
   * 
   * @param string $sql - sql statement with dynamic variables prefixed with ":"
   * @param array  $data - name value pairs of data to be entered into the database
   * @param array $options - additional options that manipulate how the data is returned 
   */
  public static function dispatch($sql, $data = [], $options = ['fetchConstant' => false, 'returnId' => false])
  {
    // parse the sql and find the required fields
    $pattern = "/[:^]([A-z0-9]+)/";
    preg_match_all($pattern, $sql, $matches_out);
    $fields = $matches_out[1];
    $db = self::dbConnect();
    $stmt = $db->prepare($sql);
    if (!empty($data)) {
      foreach ($data as $key => $value) {
        foreach ($fields as $field) {
          if ($key == $field) {
            $stmt->bindValue(":$key", $value, self::pdoConstant($value, $key));
          }
        }
      }
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
   * PDO Constant Type
   * -----------------
   * 
   * Defines type of value bein inserted into
   * the database.
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
