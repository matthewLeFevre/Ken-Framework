<?php
// font url font family itemorder
function create_font($data) {
  $db = dbConnect();
  $sql = "INSERT INTO font (itemOrder, sectionId, fontUrl, fontFamily) VALUES (:itemOrder, :sectionId, :fontUrl, :fontFamily)";
  $stmt = $db->prepare($sql);
  $stmt->bindValue(":itemOrder", $data['itemOrder'], PDO::PARAM_INT);
  $stmt->bindValue(":secitonId", $data['secitonId'], PDO::PARAM_INT);
  $stmt->bindValue(":fontUrl", $data['fontUrl'], PDO::PARAM_STR);
  $stmt->bindValue(":fontFamily", $data['fontFamily'], PDO::PARAM_STR);
  $stmt->execute();
  $rowsChanged = $stmt->rowCount();
  $stmt->closeCursor();
  return $rowsChanged;
}
function update_font($data) {
  $db = dbConnect();
  $sql = "UPDATE font SET itemOrder = :itemOrder, fontURL = :fontURL, fontFamily = :fontFamily WHERE fontId = :fontId";
  $stmt = $db->prepare($sql);
  $stmt->bindValue(":itemOrder", $data['itemOrder'], PDO::PARAM_INT);
  $stmt->bindValue(":fontId", $data['fontId'], PDO::PARAM_INT);
  $stmt->bindValue(":fontUrl", $data['fontUrl'], PDO::PARAM_STR);
  $stmt->bindValue(":fontFamily", $data['fontFamily'], PDO::PARAM_STR);
  $stmt->execute();
  $rowsChanged = $stmt->rowCount();
  $stmt->closeCursor();
  return $rowsChanged;
}
function delete_font($data) {
  $db = dbConnect();
  $sql = "DELETE font WHERE fontId = :fontId";
  $stmt = $db->prepare($sql);
  $stmt->bindValue(":fontId", $data['fontId'], PDO::PARAM_INT);
  $stmt->execute();
  $rowsChanged = $stmt->rowCount();
  $stmt->closeCursor();
  return $rowsChanged;
}

function get_fonts_by_sectionId($sectionId) {
  $db = dbConnect();
  $sql = "SELECT * FROM font WHERE sectionId = :sectionId";
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':sectionId', $sectionId, PDO::PARAM_INT);
  $stmt->execute();
  $data = $stmt->fetchAll(PDO::FETCH_NAMED);
  $stmt->closeCursor();
  return $data;
}
// function get_fonts_by_sectionId() {}

