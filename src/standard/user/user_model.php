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
    $sql = 'INSERT INTO user (userName, userEmail, userPassword) VALUES (:userName, :userEmail, :userPassword)';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':userName',      $newUserData['userName'],      PDO::PARAM_STR);
    $stmt->bindValue(':userEmail',     $newUserData['userEmail'],     PDO::PARAM_STR);
    $stmt->bindValue(':userPassword',  $newUserData['userPassword'],  PDO::PARAM_STR);
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

  function update_user_data($data) {
    $db = dbConnect();
    $sql = "UPDATE user SET userName = :userName, userFirstName = :userFirstName, userLastName = :userLastName  WHERE userId = :userId";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':userId', $data['userId'], PDO::PARAM_INT);
    $stmt->bindValue(':userName', $data['userName'], PDO::PARAM_STR);
    $stmt->bindValue(':userFirstName', $data['userFirstName'], PDO::PARAM_STR);
    $stmt->bindValue(':userLastName', $data['userLastName'], PDO::PARAM_STR);
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
  }

  function update_user_password($data) {
    $db = dbConnect();
    $sql = "UPDATE user SET userPassword = :userPassword WHERE userId = :userId";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':userId', $data['userId'], PDO::PARAM_INT);
    $stmt->bindValue(':userPassword', $data['userPassword'], PDO::PARAM_INT);
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
  }

  function delete_user($userId) {
    $db = dbConnect();
    $sql = "DELETE FROM user WHERE userId = :userId";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
  }
