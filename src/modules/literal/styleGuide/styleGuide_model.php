<?php 


// create styleGuide
function create_styleGuide($styleGuideData) {
  $db = dbConnect();
  $sql = 'INSERT INTO styleGuide (styleGuideTitle, styleGuideStatus, projectId) VALUES (:styleGuideTitle, :styleGuideStatus, :projectId)';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':styleGuideTitle',   $styleGuideData['styleGuideTitle'],   PDO::PARAM_STR);
  $stmt->bindValue(':styleGuideStatus',  $styleGuideData['styleGuideStatus'],  PDO::PARAM_STR);
  $stmt->bindValue(':projectId',         $styleGuideData['projectId'],         PDO::PARAM_INT);
  $stmt->execute();
  $rowsChanged = $stmt->rowCount();
  $stmt->closeCursor();
  return $rowsChanged;
}

function update_styleGuide($styleGuideData) {
  $db = dbConnect();
  $sql = 'UPDATE styleGuide SET styleGuideTitle = :styleGuideTitle, styleGuideDescription = :styleGuideDescription, styleGuideStatus= :styleGuideStatus WHERE styleGuideId = :styleGuideId';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':styleGuideTitle',   $styleGuideData['styleGuideTitle'],   PDO::PARAM_STR);
  $stmt->bindValue(':styleGuideDescription', $styleGuideData['styleGuideDescription'], PDO::PARAM_STR);
  $stmt->bindValue(':styleGuideStatus',  $styleGuideData['styleGuideStatus'],  PDO::PARAM_STR);
  $stmt->bindValue(':styleGuideId',      $styleGuideData['styleGuideId'],      PDO::PARAM_INT);
  $stmt->execute();
  $rowsChanged = $stmt->rowCount();
  $stmt->closeCursor();
  return $rowsChanged;
}

function update_styleGuide_status($styleGuideData) {
  $db = dbConnect();
  $sql = 'UPDATE styleGuide SET styleGuideStatus= :styleGuideStatus, styleGuideModified = :styleGuideModified WHERE styleGuideId = :styleGuideId';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':styleGuideStatus',  $styleGuideData['styleGuideStatus'],  PDO::PARAM_STR);
  $stmt->bindValue(':styleGuideModified',$styleGuideData['styleGuideModified'],PDO::PARAM_STR);
  $stmt->bindValue(':styleGuideId',      $styleGuideData['styleGuideId'],      PDO::PARAM_INT);
  $stmt->execute();
  $rowsChanged = $stmt->rowCount();
  $stmt->closeCursor();
  return $rowsChanged;
}

function delete_styleGuide($styleGuideId) {
  $db = dbConnect();
  $sql = 'DELETE FROM styleGuide WHERE styleGuideId = :styleGuideId';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':styleGuideId', $styleGuideId, PDO::PARAM_INT);
  $stmt->execute();
  $rowsChanged = $stmt->rowCount();
  $stmt->closeCursor();
  return $rowsChanged;
}

function get_styleGuide_by_id($styleGuideId) {
  $db = dbConnect();
  $sql = "SELECT * FROM styleGuide WHERE styleGuideId = :styleGuideId";
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':styleGuideId', $styleGuideId, PDO::PARAM_INT);
  $stmt->execute();
  $styleGuideData = $stmt->fetchAll(PDO::FETCH_NAMED);
  $stmt->closeCursor();
  return $styleGuideData;
}

function get_public_styleGuide_by_id($styleGuideId) {
  $db = dbConnect();
  $sql = "SELECT * FROM styleGuide WHERE styleGuideId = :styleGuideId AND styleGuideStatus = 'public'";
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':styleGuideId', $styleGuideId, PDO::PARAM_INT);
  $stmt->execute();
  $styleGuideData = $stmt->fetchAll(PDO::FETCH_NAMED);
  $stmt->closeCursor();
  return $styleGuideData;
}

function get_styleGuides_by_projectId($projectId) {
  $db = dbConnect();
  $sql = "SELECT * FROM styleGuide WHERE projectId = :projectId";
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':projectId', $projectId, PDO::PARAM_STR);
  $stmt->execute();
  $styleGuideData = $stmt->fetchAll(PDO::FETCH_NAMED);
  $stmt->closeCursor();
  return $styleGuideData;
}

function get_public_styleGuides() {
  $db = dbConnect();
  $sql = "SELECT * FROM styleGuide WHERE styleGuideStatus = 'public'";
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $styleGuideData = $stmt->fetchAll(PDO::FETCH_NAMED);
  $stmt->closeCursor();
  return $styleGuideData;
}