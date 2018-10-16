<?php

// function create() {}
// function update() {}
// function delete() {}
// function get() {}

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