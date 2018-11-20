<?php

function create_code($data) {
  $db = dbConnect();
  $sql = "INSERT INTO code (itemOrder, sectionId, codeLanguage) VALUES (:itemOrder, :sectionId, :codeLanguage)";
  $stmt = $db->prepare($sql);
  $stmt->bindValue(":itemOrder", $data['itemOrder'], PDO::PARAM_INT);
  $stmt->bindValue(":sectionId", $data['sectionId'], PDO::PARAM_INT);
  $stmt->bindValue(":codeLanguage", $data['codeLanguage'], PDO::PARAM_STR);
  $stmt->execute();
  $rowsChanged = $stmt->rowCount();
  $stmt->closeCursor();
  return $rowsChanged;
}
function update_code($data) {
  $db = dbConnect();
  $sql = "UPDATE code SET itemOrder = :itemOrder, codeLanguage = :codeLanguage, codeMarkup = :codeMarkup WHERE codeId = :codeId";
  $stmt = $db->prepare($sql);
  $stmt->bindValue(":itemOrder", $data['itemOrder'], PDO::PARAM_INT);
  $stmt->bindValue(":codeId", $data['codeId'], PDO::PARAM_INT);
  $stmt->bindValue(":codeLanguage", $data['codeLanguage'], PDO::PARAM_STR);
  $stmt->bindValue(":codeMarkup", $data['codeMarkup'], PDO::PARAM_STR);
  $stmt->execute();
  $rowsChanged = $stmt->rowCount();
  $stmt->closeCursor();
  return $rowsChanged;
}
function delete_code($data) {
  $db = dbConnect();
  $sql = "DELETE FROM code WHERE codeId = :codeId";
  $stmt = $db->prepare($sql);
  $stmt->bindValue(":codeId", $data['codeId'], PDO::PARAM_INT);
  $stmt->execute();
  $rowsChanged = $stmt->rowCount();
  $stmt->closeCursor();
  return $rowsChanged;
}

function get_codes_by_sectionId($sectionId) {
  $db = dbConnect();
  $sql = "SELECT * FROM code WHERE sectionId = :sectionId";
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':sectionId', $sectionId, PDO::PARAM_INT);
  $stmt->execute();
  $data = $stmt->fetchAll(PDO::FETCH_NAMED);
  $stmt->closeCursor();
  return $data;
}