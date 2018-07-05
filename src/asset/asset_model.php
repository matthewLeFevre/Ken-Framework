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

function delete_asset($assetData) {
  $db = dbConnect();
  $sql = 'DELETE asset WHERE assetId = :assetId';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':assetId', $assetData["assetId"], PDO::PARAM_STR);
  $stmt->execute();
  $rowsChanged = $stmt->rowCount();
  $stmt->closeCursor();
  return $rowsChanged;
}

function assign_asset($assetData) {
  $table = $assetData["assignedTable"]; 
  $db = dbConnect();
  $sql = "INSERT INTO asset_assignment (". $table ."Id, assetId) VALUES (:assignedId, :assetId)";
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':assignedId',  $assetData['assignedId'],  PDO::PARAM_INT);
  $stmt->bindValue(':assetId',     $assetData['assetId'],     PDO::PARAM_INT);  
  $stmt->execute();
  $rowsChanged = $stmt->rowCount();
  $stmt->closeCursor();
  return $rowsChanged; 
}

function unassign_asset($assetData) {
  $table = $assetData["assignedTable"];
  $db = dbConnect();
  $sql = 'DELETE asset_assignment WHERE assetId = :assetId AND ' . $table . "id = :assignedId";
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':assetId', $assetData["assetId"], PDO::PARAM_INT);
  $stmt->bindValue(':assignedId', $assetData["assignedId"], PDO::PARAM_INT);
  $stmt->execute();
  $rowsChanged = $stmt->rowCount();
  $stmt->closeCursor();
  return $rowsChanged;
}

function unassign_asset_all($assetData) {
  $db = dbConnect();
  $sql = 'DELETE asset_assignment WHERE assetId = :assetId';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':assetId', $assetData["assetId"], PDO::PARAM_INT);
  $stmt->execute();
  $rowsChanged = $stmt->rowCount();
  $stmt->closeCursor();
  return $rowsChanged;
}

function update_asset_status($assetData) {
  $db = dbConnect();
  $sql = 'UPDATE asset SET assetStatus= :assetStatus, assetModified = :assetModiefied WHERE assetId = :assetId';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':assetStatus',  $articleData['assetStatus'],  PDO::PARAM_STR);
  $stmt->bindValue(':assetModified',$articleData['assetModified'],PDO::PARAM_STR);
  $stmt->bindValue(':assetId',      $articleData['assetId'],      PDO::PARAM_INT);
  $stmt->execute();
  $rowsChanged = $stmt->rowCount();
  $stmt->closeCursor();
  return $rowsChanged;
}