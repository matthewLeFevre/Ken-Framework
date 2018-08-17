<?php 

function create_comment($commentData) {
  if(isset($commentData['articleId'])) {
    $dataId = 'articleId';
  } else if (isset($commentData['postId'])) {
    $dataId = 'postId';
  }
  $db = dbConnect();
  $sql = 'INSERT INTO comment (commentBody, userId' . ', ' . $dataId ' VALUES (:comentBody, :userId, :' .$dataId. ')';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':commentBody', $commentData["commentBody"], PDO::PARAM_STR);
  $stmt->bindValue(':userId', $commentData["userId"], PDO::PARAM_INT);
  $stmt->bindValue(':'.$dataId, $commentData[$dataId], PDO::PARAM_INT);
  $stmt->execute();
  $rowsChanged = $stmt->rowCount();
  $stmt->closeCursor();
  return $rowsChanged;
}

function update_comment($commentData) {
  $db = dbConnect();
  $sql = 'UPDATE comment SET commentBody = :commentBody WHERE commentId = :commentId';
  $stmt->bindValue(':commentBody', $commentData["commentBody"], PDO::PARAM_STR);
  $stmt->bindValue(':commentId', $commentData["commentId"], PDO::PARAM_INT);
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $rowsChanged = $stmt->rowCount();
  $stmt->closeCursor();
  return $rowsChanged;
}
function delete_comment($commentId) {
  $db = dbConnect();
  $sql = 'DELETE FROM comment WHERE commentId = :commentId';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':commentId', $commentId, PDO::PARAM_INT);
  $stmt->execute();
  $rowsChanged = $stmt->rowCount();
  $stmt->closeCursor();
  return $rowsChanged;
}
function get_comments_by_articleId($articleId) {}
function get_comments_by_postId($postId) {}