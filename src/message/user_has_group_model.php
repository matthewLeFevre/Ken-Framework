<?php 


// create message
function create_user_group($userGroupData) {
  $db = dbConnect();
  $sql = 'INSERT INTO message (userId, groupId) VALUES (:userId, :groupId)';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':userId',      $messageData['userId'],      PDO::PARAM_INT);
  $stmt->bindValue(':groupId',     $messageData['groupId'],     PDO::PARAM_INT);
  $stmt->execute();
  $rowsChanged = $stmt->rowCount();
  $stmt->closeCursor();
  return $rowsChanged;
}

// delete message

function delete_user_group($userGroupId) {
  $db = dbConnect();
  $sql = 'DELETE user_has_group WHERE user_has_groupId = :userGroupId';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':userGroupId', $userGroupId, PDO::PARAM_STR);
  $stmt->execute();
  $rowsChanged = $stmt->rowCount();
  $stmt->closeCursor();
  return $rowsChanged;
}

// get message by id

function get_userGroup_by_userId($userId) {
  $db = dbConnect();
  $sql = "SELECT * FROM user_has_group  WHERE userId = :userId";
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
  $stmt->execute();
  $messageData = $stmt->fetchAll(PDO::FETCH_NAMED);
  $stmt->closeCursor();
  return $userGroupData;
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

