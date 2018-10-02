<?php 


// create section
function create_section($sectionData) {
  // var_dump($sectionData['itemOrder']);
  // exit;
  $db = dbConnect();
  $sql = "INSERT INTO section (itemOrder, sectionTitle, styleGuideId) VALUES (:itemOrder, :sectionTitle, :styleGuideId)";
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':sectionTitle',   $sectionData['sectionTitle'], PDO::PARAM_STR);
  $stmt->bindValue(':itemOrder',      $sectionData['itemOrder'], PDO::PARAM_STR);
  $stmt->bindValue(':styleGuideId',   $sectionData['styleGuideId'], PDO::PARAM_INT);
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
  $sql = 'UPDATE section SET sectionTitle = :sectionTitle, itemOrder = :itemOrder WHERE sectionId = :sectionId';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':sectionTitle',   $sectionData['sectionTitle'],   PDO::PARAM_STR);
  $stmt->bindValue(':itemOrder', $sectionData['itemOrder'], PDO::PARAM_STR);
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
  $sql = "SELECT * FROM section WHERE styleGuideId = :styleGuideId ORDER By itemOrder DESC";
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':styleGuideId', $styleGuideId, PDO::PARAM_INT);
  $stmt->execute();
  $sectionData = $stmt->fetchAll(PDO::FETCH_NAMED);
  $stmt->closeCursor();
  return $sectionData;
}
