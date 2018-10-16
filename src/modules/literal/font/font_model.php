<?php

function create_font() {}
function update_font() {}
function delete_font() {}
function get_fonts_by_secitonId() {}

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