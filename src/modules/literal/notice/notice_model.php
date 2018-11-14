<?php

function create_notice($data) {
  $db = dbConnect();
  $sql = "INSERT INTO notice (itemOrder, sectionId, noticeText, noticeType) VALUES (:itemOrder, :sectionId, :noticeType, :noticeText)";
  $stmt = $db->prepare($sql);
  $stmt->bindValue(":itemOrder", $data['itemOrder'], PDO::PARAM_INT);
  $stmt->bindValue(":sectionId", $data['sectionId'], PDO::PARAM_INT);
  $stmt->bindValue(":noticeText", $data['noticeText'], PDO::PARAM_STR);
  $stmt->bindValue(":noticeType", $data['noticeType'], PDO::PARAM_STR);
  $stmt->execute();
  $rowsChanged = $stmt->rowCount();
  $stmt->closeCursor();
  return $rowsChanged;
}
function update_notice($data) {
  $db = dbConnect();
  $sql = "UPDATE notice SET itemOrder = :itemOrder, noticeText = :noticeText, noticeType = :noticeType WHERE noticeId = :noticeId";
  $stmt = $db->prepare($sql);
  $stmt->bindValue(":itemOrder", $data['itemOrder'], PDO::PARAM_INT);
  $stmt->bindValue(":noticeId", $data['noticeId'], PDO::PARAM_INT);
  $stmt->bindValue(":noticeText", $data['noticeText'], PDO::PARAM_STR);
  $stmt->bindValue(":noticeType", $data['noticeType'], PDO::PARAM_STR);
  $stmt->execute();
  $rowsChanged = $stmt->rowCount();
  $stmt->closeCursor();
  return $rowsChanged;
}
function delete_notice($data) {
  $db = dbConnect();
  $sql = "DELETE FROM notice WHERE noticeId = :noticeId";
  $stmt = $db->prepare($sql);
  $stmt->bindValue(":noticeId", $data['noticeId'], PDO::PARAM_INT);
  $stmt->execute();
  $rowsChanged = $stmt->rowCount();
  $stmt->closeCursor();
  return $rowsChanged;
}

function get_notices_by_sectionId($sectionId) {
  $db = dbConnect();
  $sql = "SELECT * FROM notice WHERE sectionId = :sectionId";
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':sectionId', $sectionId, PDO::PARAM_INT);
  $stmt->execute();
  $data = $stmt->fetchAll(PDO::FETCH_NAMED);
  $stmt->closeCursor();
  return $data;
}