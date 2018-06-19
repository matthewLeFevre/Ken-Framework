<?php

// connects to the database
function dbConnect_yours(){
  $server = "your Server";
  $database = "generic db";
  $user = "your user";
  $password = "your password";
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
