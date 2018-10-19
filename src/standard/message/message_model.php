<?php 


// create message
function create_message($messageData) {
  $db = dbConnect();
  $sql = 'INSERT INTO message ( messageBody, userId, groupId) VALUES (:messageBody, :userId, :groupId)';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':messageBody', $messageData['messageBody'], PDO::PARAM_STR);
  $stmt->bindValue(':userId',      $messageData['userId'],      PDO::PARAM_INT);
  $stmt->bindValue(':groupId',     $messageData['groupId'],     PDO::PARAM_INT);
  $stmt->execute();
  $rowsChanged = $stmt->rowCount();
  $stmt->closeCursor();
  return $rowsChanged;
}

// delete message

function delete_message($messageId) {
  $db = dbConnect();
  $sql = 'DELETE message WHERE messageId = :messageId';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':messageId', $messageId, PDO::PARAM_STR);
  $stmt->execute();
  $rowsChanged = $stmt->rowCount();
  $stmt->closeCursor();
  return $rowsChanged;
}

// get message by id

function get_message_by_id($messageId) {
  $db = dbConnect();
  $sql = "SELECT * FROM message  WHERE messageId = :messageId";
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':messageId', $messageId, PDO::PARAM_INT);
  $stmt->execute();
  $messageData = $stmt->fetchAll(PDO::FETCH_NAMED);
  $stmt->closeCursor();
  return $messageData;
}

// get messages by group id

function get_message_by_group_id($groupId) {
  $db = dbConnect();
  $sql = "SELECT * FROM message  WHERE groupId = :groupId ORDER BY messageCreated ASC";
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':messageId', $messageId, PDO::PARAM_INT);
  $stmt->execute();
  $messageData = $stmt->fetchAll(PDO::FETCH_NAMED);
  $stmt->closeCursor();
  return $messageData;
}

