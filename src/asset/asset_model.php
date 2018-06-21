<?php

function create_asset($assetData) {
  $db = dbConnect();
  $sql = 'INSERT INTO asset (assetPath, assetName, assetType, assetStatus, userId) VALUES (:assetPath, :assetName, :assetType, :assetStatus, :userId)';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':assetPath',   $assetData['assetPath'],   PDO::PARAM_STR);
  $stmt->bindValue(':assetName',   $assetData['assetName'],   PDO::PARAM_STR);
  $stmt->bindValue(':assetType',   $assetData['assetType'],   PDO::PARAM_STR);
  $stmt->bindValue(':assetStatus', $assetData['assetStatus'], PDO::PARAM_STR);
  $stmt->bindValue(':userId',      $assetData['userId'],      PDO::PARAM_INT);
  $stmt->execute();
  $rowsChanged = $stmt->rowCount();
  $stmt->closeCursor();
  return $rowsChanged;
}

function delete_asset($assetId) {
  $db = dbConnect();
  $sql = 'DELETE asset WHERE assetId = :assetId';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':assetId', $assetId, PDO::PARAM_STR);
  $stmt->execute();
  $rowsChanged = $stmt->rowCount();
  $stmt->closeCursor();
  return $rowsChanged;
}

function assign_asset($assetData) {
  $db = dbConnect();
  
  if($assetData["assignedTable"] == "article") {
    $assignedId = $assetData["assignedId"];
    $sql = 'INSERT INTO article_has_asset (articleId, assetId) VALUES (:assignedId, :assetId)';
    
  } elseif ($assetData["assignedTable"] == "post") {
    $assignedId = $assetData["assignedId"];
    $sql = 'INSERT INTO post_has_asset (postId, assetId) VALUES (:assignedId, :assetId)';

  } elseif ($asset["assignedTable"] == "message") {
    $assignedId = $assetData["assignedId"];
    $sql = 'INSERT INTO message_has_asset (messageId, assetId) VALUES (:assignedId, :assetId)';
  }
  
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':assingedId',  $articleData['assignedId'],  PDO::PARAM_INT);
  $stmt->bindValue(':assetId',     $articleData['assetId'],     PDO::PARAM_INT);
  $stmt->execute();
  $rowsChanged = $stmt->rowCount();
  $stmt->closeCursor();
  return $rowsChanged; 
}

function unassign_asset($unassignAssetData) {}
function update_asset_status($assetStatus) {}