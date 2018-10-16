<?php

function create_heading ($data) {
  $db = dbConnect();
  $sql = 'INSERT INTO heading (headingText, itemOrder, sectionId) VALUES ( :headingText, :itemOrder, :sectionId)';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(":headingText", $data['headingText'], PDO::PARAM_STR);
  $stmt->bindValue(":itemOrder", $data['itemOrder'], PDO::PARAM_INT);
  $stmt->bindValue(":sectionId", $data['sectionId'], PDO::PARAM_INT);
  $stmt->execute();
  $rowsChanged = $stmt->rowCount();
  $stmt->closeCursor();
  return $rowsChanged;
}

function update_heading($data){
  $db = dbConnect();
  $sql = 'UPDATE heading SET headingText = :headingText, itemOrder = :itemOrder WHERE headingId = :headingId';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(":headingId", $data['headingId'], PDO::PARAM_INT);
  $stmt->bindValue(":itemOrder", $data['itemOrder'], PDO::PARAM_INT);
  $stmt->bindValue(":headingText", $data['headingText'], PDO::PARAM_STR);
  $stmt->execute();
  $rowsChanged = $stmt->rowCount();
  $stmt->closeCursor();
  return $rowsChanged;
}

function delete_heading ($data) {
  $db = dbConnect();
  $sql = 'DELETE FROM heading WHERE headingId = :headingId';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(":headingId", $data['headingId'], PDO::PARAM_INT);
  $stmt->execute();
  $rowsChanged = $stmt->rowCount();
  $stmt->closeCursor();
  return $rowsChanged;
}

function get_headings_by_sectionId($sectionId) {
  $db = dbConnect();
  $sql = "SELECT * FROM heading WHERE sectionId = :sectionId";
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':sectionId', $sectionId, PDO::PARAM_INT);
  $stmt->execute();
  $data = $stmt->fetchAll(PDO::FETCH_NAMED);
  $stmt->closeCursor();
  return $data;
}