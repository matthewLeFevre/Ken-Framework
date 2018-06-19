<?php 


// create post
function create_new_post($postData) {
  $db = dbConnect();
  $sql = 'INSERT INTO post ( postBody, userId) VALUES (:postBody, :userId)';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':postBody', $postData['postBody'], PDO::PARAM_STR);
  $stmt->bindValue(':userId',   $postData['userId'],   PDO::PARAM_INT);
  $stmt->execute();
  $rowsChanged = $stmt->rowCount();
  $stmt->closeCursor();
  return $rowsChanged;
}
// update post
// - add like
// - add share

function update_post($postData) {
  $db = dbConnect();
  $sql = 'UPDATE post SET postBody = :postBody, postModified = :postModiefied WHERE postId = :postId';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':postBody',    $postData['postBody'],    PDO::PARAM_STR);
  $stmt->bindValue(':postModified',$postData['postModified'],PDO::PARAM_STR);
  $stmt->bindValue(':postId',      $postData['postId'],      PDO::PARAM_INT);
  $stmt->execute();
  $rowsChanged = $stmt->rowCount();
  $stmt->closeCursor();
  return $rowsChanged;
}

// delete post

function delete_post($postId) {
  $db = dbConnect();
  $sql = 'DELETE post WHERE postId = :postId';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':postId', $postId, PDO::PARAM_STR);
  $stmt->execute();
  $rowsChanged = $stmt->rowCount();
  $stmt->closeCursor();
  return $rowsChanged;
}

// get post by id

function get_post_by_id($postId) {
  $db = dbConnect();
  $sql = "SELECT * FROM post  WHERE postId = :postId";
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':postId', $postId, PDO::PARAM_INT);
  $stmt->execute();
  $postData = $stmt->fetchAll(PDO::FETCH_NAMED);
  $stmt->closeCursor();
  return $postData;
}

