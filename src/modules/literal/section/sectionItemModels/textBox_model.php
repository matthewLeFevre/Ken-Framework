<?php
// create textBox
function create_textBox($textBoxData) {
  $db = dbConnect();
  $sql = 'INSERT INTO textBox (textBoxTitle, textBoxStatus, projectId) VALUES (:textBoxTitle, :textBoxStatus, :projectId)';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':textBoxTitle',   $textBoxData['textBoxTitle'],   PDO::PARAM_STR);
  $stmt->bindValue(':textBoxStatus',  $textBoxData['textBoxStatus'],  PDO::PARAM_STR);
  $stmt->bindValue(':projectId',         $textBoxData['projectId'],         PDO::PARAM_INT);
  $stmt->execute();
  $rowsChanged = $stmt->rowCount();
  $stmt->closeCursor();
  return $rowsChanged;
}
// update textBox
// - add like
// - add share

function update_textBox($textBoxData) {
  $db = dbConnect();
  $sql = 'UPDATE textBox SET textBoxTitle = :textBoxTitle, textBoxSummary = :textBoxSummary, textBoxBody = :textBoxBody, textBoxStatus= :textBoxStatus, textBoxLink = :textBoxLink, textBoxModified = :textBoxModified WHERE textBoxId = :textBoxId';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':textBoxTitle',   $textBoxData['textBoxTitle'],   PDO::PARAM_STR);
  $stmt->bindValue(':textBoxSummary', $textBoxData['textBoxSummary'], PDO::PARAM_STR);
  $stmt->bindValue(':textBoxBody',    $textBoxData['textBoxBody'],    PDO::PARAM_STR);
  $stmt->bindValue(':textBoxStatus',  $textBoxData['textBoxStatus'],  PDO::PARAM_STR);
  $stmt->bindValue(':textBoxLink',    $textBoxData['textBoxLink'],    PDO::PARAM_STR);
  $stmt->bindValue(':textBoxModified',$textBoxData['textBoxModified'],PDO::PARAM_STR);
  $stmt->bindValue(':textBoxId',      $textBoxData['textBoxId'],      PDO::PARAM_INT);
  // $stmt->bindValue(':textBoxImagePath',    $textBoxData['textBoxImage'],    PDO::PARAM_STR);
  $stmt->execute();
  $rowsChanged = $stmt->rowCount();
  $stmt->closeCursor();
  return $rowsChanged;
}

// delete textBox

function delete_textBox($textBoxId) {
  $db = dbConnect();
  $sql = 'DELETE FROM textBox WHERE textBoxId = :textBoxId';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':textBoxId', $textBoxId, PDO::PARAM_INT);
  $stmt->execute();
  $rowsChanged = $stmt->rowCount();
  $stmt->closeCursor();
  return $rowsChanged;
}

// get textBox by id

function get_textBox_by_id($textBoxId) {
  $db = dbConnect();
  $sql = "SELECT * FROM textBox WHERE textBoxId = :textBoxId";
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':textBoxId', $textBoxId, PDO::PARAM_INT);
  $stmt->execute();
  $textBoxData = $stmt->fetchAll(PDO::FETCH_NAMED);
  $stmt->closeCursor();
  return $textBoxData;
}


function get_textBoxs_by_sectionId($projectId) {
  $db = dbConnect();
  $sql = "SELECT * FROM textBox WHERE projectId = :projectId";
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':projectId', $projectId, PDO::PARAM_STR);
  $stmt->execute();
  $textBoxData = $stmt->fetchAll(PDO::FETCH_NAMED);
  $stmt->closeCursor();
  return $textBoxData;
}