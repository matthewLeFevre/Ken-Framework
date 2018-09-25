<?php 


// create section
function create_section($sectionData) {
  $db = dbConnect();
  $sql = 'INSERT INTO section (sectionTitle, order, projectId) VALUES (:sectionTitle, :order, :projectId)';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':sectionTitle',   $sectionData['sectionTitle'],   PDO::PARAM_STR);
  $stmt->bindValue(':order',  $sectionData['order'],  PDO::PARAM_STR);
  $stmt->bindValue(':styleGuideId',         $sectionData['styleGuideId'],         PDO::PARAM_INT);
  $stmt->execute();
  $rowsChanged = $stmt->rowCount();
  $stmt->closeCursor();
  return $rowsChanged;
}
// update section
// - add like
// - add share

function update_section($sectionData) {
  $db = dbConnect();
  $sql = 'UPDATE section SET sectionTitle = :sectionTitle, order = :order WHERE sectionId = :sectionId';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':sectionTitle',   $sectionData['sectionTitle'],   PDO::PARAM_STR);
  $stmt->bindValue(':order', $sectionData['order'], PDO::PARAM_STR);
  $stmt->bindValue(':sectionId',      $sectionData['sectionId'],      PDO::PARAM_INT);
  $stmt->execute();
  $rowsChanged = $stmt->rowCount();
  $stmt->closeCursor();
  return $rowsChanged;
}

// delete section

function delete_section($sectionId) {
  $db = dbConnect();
  $sql = 'DELETE FROM section WHERE sectionId = :sectionId';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':sectionId', $sectionId, PDO::PARAM_INT);
  $stmt->execute();
  $rowsChanged = $stmt->rowCount();
  $stmt->closeCursor();
  return $rowsChanged;
}

// get section by id

function get_section_by_id($sectionId) {
  $db = dbConnect();
  $sql = "SELECT * FROM section WHERE sectionId = :sectionId";
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':sectionId', $sectionId, PDO::PARAM_INT);
  $stmt->execute();
  $sectionData = $stmt->fetchAll(PDO::FETCH_NAMED);
  $stmt->closeCursor();
  return $sectionData;
}

function get_sections_by_styleGuideId($styleGuideId) {
  $db = dbConnect();
  $sql = "SELECT * FROM section WHERE styleGuideId = :styleGuideId ORDER BY order DESC";
  $stmt = $db->prepare($sql);
  $stmt->bindValue('styleGuidetId', $styleGuideId, PDO::PARAM_STR);
  $stmt->execute();
  $sectionData = $stmt->fetchAll(PDO::FETCH_NAMED);
  $stmt->closeCursor();
  return $sectionData;
}
