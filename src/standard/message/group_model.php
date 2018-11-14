<?php 


// create article
function create_group($groupData) {
  $db = dbConnect();
  $sql = 'INSERT INTO group (groupTitle, userId) VALUES (:groupTitle, :userId)';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':userId', $groupData['userId'], PDO::PARAM_STR);
  $stmt->bindValue(':groupTitle',   $groupData['groupTitle'],   PDO::PARAM_STR);
  $stmt->execute();
  $rowsChanged = $stmt->rowCount();
  $stmt->closeCursor();
  return $rowsChanged;
}
// update article
// - add like
// - add share

// function update_group($articleData) {
//   $db = dbConnect();
//   $sql = 'UPDATE article SET articleTitle = :articleTitle, articleImagePath= :articleImagePath, articleSummary = :articleSummary, articleBody = :articleBody, articleStatus= :articleStatus, articleLink = :articleLink, articleModified = :articleModified WHERE articleId = :articleId';
//   $stmt = $db->prepare($sql);
//   $stmt->bindValue(':articleImagePath',    $articleData['articleImage'],    PDO::PARAM_STR);
//   $stmt->execute();
//   $rowsChanged = $stmt->rowCount();
//   $stmt->closeCursor();
//   return $rowsChanged;
// }

// delete article

function delete_group($groupId) {
  $db = dbConnect();
  $sql = 'DELETE FROM group WHERE groupId = :groupId';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':groupId', $groupId, PDO::PARAM_INT);
  $stmt->execute();
  $rowsChanged = $stmt->rowCount();
  $stmt->closeCursor();
  return $rowsChanged;
}

// get article by id

function get_group_by_id($groupId) {
  $db = dbConnect();
  $sql = "SELECT group.*, message.*, user.*  FROM group
          LEFT JOIN message ON group.groupId = message.groupId
          LEFT JOIN user ON message.userId = user.userId
          WHERE group.groupId = :groupId";
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':groupId', $groupId, PDO::PARAM_INT);
  $stmt->execute();
  $articleData = $stmt->fetchAll(PDO::FETCH_NAMED);
  $stmt->closeCursor();
  return $groupData;
}

function get_last_group_by_userId($userId) {
  $db = dbConnect();
  // $sql = "SELECT groupId FROM group WHERE userId = :userId AND groupId = (SELECT MAX(groupId) from group)";
  $sql = "SELECT MAX(groupId) FROM group WHERE userId = :userId)";
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
  $stmt->execute();
  $groupId = $stmt->fetch(PDO::FETCH_ASSOC);
  $stmt->closeCursor();
  return $groupId;
}

function get_groups_by_userId($userId) {
  $sql = "SELECT user_has_group.*, group.*, message.*, user.*  FROM user
          LEFT JOIN user_has_group ON user.userId = user_has_group.userId
          LEFT JOIN group ON user_has_group.groupId = group.groupId
          WHERE user.userId = :userId";
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
  $stmt->execute();
  $groupData = $stmt->fetchAll(PDO::FETCH_NAMED);
  $stmt->closeCursor();
  return $groupData;
}


