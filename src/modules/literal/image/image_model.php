<?php

function create_image($data) {
  $db = dbConnect();
  $sql = "INSERT INTO image (itemOrder, sectionId, imageUrl) VALUES (:itemOrder, :sectionId, :imageUrl)";
  $stmt = $db->prepare($sql);
  $stmt->bindValue(":itemOrder", $data['itemOrder'], PDO::PARAM_INT);
  $stmt->bindValue(":sectionId", $data['sectionId'], PDO::PARAM_INT);
  $stmt->bindValue(":imageUrl", $data['imageUrl'], PDO::PARAM_STR);
  // $stmt->bindValue(":assetId", $data['assetId'], PDO::PARAM_INT);
  $stmt->execute();
  $rowsChanged = $stmt->rowCount();
  $stmt->closeCursor();
  return $rowsChanged;
}
function update_image($data) {
  $db = dbConnect();
  $sql = "UPDATE image set imageUrl = imageUrl, assetId = assetId, itemOrder";
}
function delete($data) {
  $db = dbConnect();
  $sql = "DELETE image WHERE imageId = :imageId";
  $stmt = $db->prepare($sql);
  $stmt->bindValue(":imageId", $data['imageId'], PDO::PARAM_INT);
  $stmt->execute();
  $rowsChanged = $stmt->rowCount();
  $stmt->closeCursor();
  return $rowsChanged;
}
function get_images_by_sectionId($sectionId) {
  $db = dbConnect();
  $sql = "SELECT * FROM image WHERE sectionId = :sectionId";
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':sectionId', $sectionId, PDO::PARAM_INT);
  $stmt->execute();
  $data = $stmt->fetchAll(PDO::FETCH_NAMED);
  $stmt->closeCursor();
  return $data;
}