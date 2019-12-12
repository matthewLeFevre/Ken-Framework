<?php

namespace KenFramework\Utilities;

/**
 * Uses variables defined in the .env.example file be sure
 * to configure that file before using this function or you will
 * not be able to connect to your mysql database.
 */
function dbConnect()
{
  $server = $_ENV['KEN_SERVER']; // Most likely localhost
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
