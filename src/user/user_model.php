<?php

// Get user data from an Id
  function get_user_by_id($userId) {
    $db = dbConnect();
    $sql = 'SELECT * FROM user WHERE userId = :userId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $userData = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $userData;
  }

// Get user data from an email
  function get_user_by_email($userEmail) {
    $db = dbConnect();
    $sql = 'SELECT * FROM user WHERE userEmail = :userEmail';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':userEmail', $userEmail, PDO::PARAM_STR);
    $stmt->execute();
    $userData = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $userData;
  }

// register a new user
  function register_new_user($newUserData) {
    $db = dbConnect();
    $sql = 'INSERT INTO user (userName, userEmail, userPassword, userFirstName, userLastName) VALUES (:userName, :userEmail, :userPassword, :userFirstName, :userLastName)';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':userName',      $newUserData['userName'],      PDO::PARAM_STR);
    $stmt->bindValue(':userEmail',     $newUserData['userEmail'],     PDO::PARAM_STR);
    $stmt->bindValue(':userPassword',  $newUserData['userPassword'],  PDO::PARAM_STR);
    $stmt->bindValue(':userFirstName', $newUserData['userFirstName'], PDO::PARAM_STR);
    $stmt->bindValue(':userLastName',  $newUserData['userLastName'],  PDO::PARAM_STR);
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
  }

// Ensure no duplicate emails exist in db when new users register
  function verify_email($userEmail){
    $db = dbConnect();
    $sql = "SELECT userEmail from user WHERE userEmail = :userEmail";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':userEmail', $userEmail, PDO::PARAM_STR);
    $stmt->execute();
    $matchEmail = $stmt->fetch(PDO::FETCH_NUM);
    $stmt->closeCursor();
    if(empty($matchEmail)){
      return 0;
    } else {
      return 1;
    }
  }

// Lower priority functions

  function update_existing_user() {}

  function update_existing_user_password() {}
  
// an attempt at standardizing the pdo function
  // funciton db_insert($payload, $table) {
  //   $db = dbConnect();
  //   $sql = "INSERT INTO $table";
  //   $rows = "(";
  //   $values = "VALUES (";
  //   for($item of $payload) {
  //     $rows .= $item['row'];
  //     $values .= ":".$item['row'];
  //   }
  //   $rows .=")";


  // }