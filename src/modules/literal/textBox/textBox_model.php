<?php

function create_textBox ($data) {
  $db = dbConnect();
  $sql = 'INSERT INTO textBox (textBoxText, itemOrder, sectionId) VALUES (:textboxText, :itemOrder, :sectionId)';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(":textboxText", $data['textBoxText'], PDO::PARAM_STR);
  $stmt->bindValue(":itemOrder", $data['itemOrder'], PDO::PARAM_INT);
  $stmt->bindValue(":sectionId", $data['sectionId'], PDO::PARAM_INT);
  $stmt->execute();
  $rowsChanged = $stmt->rowCount();
  $stmt->closeCursor();
  return $rowsChanged;
}

function delete_textBox($data){
  $db = dbConnect();
  $sql = 'DELETE FROM textBox WHERE textBoxId = :textBoxId';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(":textBoxId", $data['textBoxId'], PDO::PARAM_INT);
  $stmt->execute();
  $rowsChanged = $stmt->rowCount();
  $stmt->closeCursor();
  return $rowsChanged;
}

function update_textBox($data) {
  $db = dbConnect();
  $sql = 'UPDATE textBox SET textBoxText = :textBoxText, itemOrder = :itemOrder WHERE textBoxId = :textBoxId';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(":textBoxId", $data['textBoxId'], PDO::PARAM_INT);
  $stmt->bindValue(":itemOrder", $data['itemOrder'], PDO::PARAM_INT);
  $stmt->bindValue(":textBoxText", $data['textBoxText'], PDO::PARAM_STR);
  $stmt->execute();
  $rowsChanged = $stmt->rowCount();
  $stmt->closeCursor();
  return $rowsChanged;
}

function get_textBoxes_by_sectionId($sectionId) {
  $db = dbConnect();
  $sql = "SELECT * FROM textBox WHERE sectionId = :sectionId";
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':sectionId', $sectionId, PDO::PARAM_INT);
  $stmt->execute();
  $data = $stmt->fetchAll(PDO::FETCH_NAMED);
  $stmt->closeCursor();
  return $data;
}