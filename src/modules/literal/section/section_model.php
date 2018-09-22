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

// get section by name

function get_section_by_title($sectionTitle) {
  $db = dbConnect();
  $sql = "SELECT section.*, asset.*  FROM section
          LEFT JOIN asset_assignment AS aa ON section.sectionId = aa.sectionId
          LEFT JOIN asset ON aa.assetId = asset.assetId
          WHERE sectionTitle = :sectionTitle";
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':sectionTitle', $sectionTitle, PDO::PARAM_STR);
  $stmt->execute();
  $sectionData = $stmt->fetchAll(PDO::FETCH_NAMED);
  $stmt->closeCursor();
  return $sectionData;
}



function get_sections_by_styleGuideId($styleGuideId) {
  $db = dbConnect();
  $sql = "SELECT * FROM section WHERE styleGuideId = :styleGuideId";
  $stmt = $db->prepare($sql);
  $stmt->bindValue('styleGuidetId', $styleGuideId, PDO::PARAM_STR);
  $stmt->execute();
  $sectionData = $stmt->fetchAll(PDO::FETCH_NAMED);
  $stmt->closeCursor();
  return $sectionData;
}




// create textBox
function create_textBox($textBoxData) {
  $db = dbConnect();
  $sql = 'INSERT INTO textBox (textBoxTitle, textBoxStatus, projectId) VALUES (:textBoxTitle, :textBoxStatus, :projectId)';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':textBoxTitle',   $textBoxData['textBoxTitle'],   PDO::PARAM_STR);
  $stmt->bindValue(':textBoxStatus',  $textBoxData['textBoxStatus'],  PDO::PARAM_STR);
  $stmt->bindValue(':projectId',         $textBoxData['projectId'],         PDO::PARAM_INT);
  $stmt->execute();
  $rowsChanged = $stmt->rowCount();
  $stmt->closeCursor();
  return $rowsChanged;
}
// update textBox
// - add like
// - add share

function update_textBox($textBoxData) {
  $db = dbConnect();
  $sql = 'UPDATE textBox SET textBoxTitle = :textBoxTitle, textBoxSummary = :textBoxSummary, textBoxBody = :textBoxBody, textBoxStatus= :textBoxStatus, textBoxLink = :textBoxLink, textBoxModified = :textBoxModified WHERE textBoxId = :textBoxId';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':textBoxTitle',   $textBoxData['textBoxTitle'],   PDO::PARAM_STR);
  $stmt->bindValue(':textBoxSummary', $textBoxData['textBoxSummary'], PDO::PARAM_STR);
  $stmt->bindValue(':textBoxBody',    $textBoxData['textBoxBody'],    PDO::PARAM_STR);
  $stmt->bindValue(':textBoxStatus',  $textBoxData['textBoxStatus'],  PDO::PARAM_STR);
  $stmt->bindValue(':textBoxLink',    $textBoxData['textBoxLink'],    PDO::PARAM_STR);
  $stmt->bindValue(':textBoxModified',$textBoxData['textBoxModified'],PDO::PARAM_STR);
  $stmt->bindValue(':textBoxId',      $textBoxData['textBoxId'],      PDO::PARAM_INT);
  // $stmt->bindValue(':textBoxImagePath',    $textBoxData['textBoxImage'],    PDO::PARAM_STR);
  $stmt->execute();
  $rowsChanged = $stmt->rowCount();
  $stmt->closeCursor();
  return $rowsChanged;
}

// delete textBox

function delete_textBox($textBoxId) {
  $db = dbConnect();
  $sql = 'DELETE FROM textBox WHERE textBoxId = :textBoxId';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':textBoxId', $textBoxId, PDO::PARAM_INT);
  $stmt->execute();
  $rowsChanged = $stmt->rowCount();
  $stmt->closeCursor();
  return $rowsChanged;
}

// get textBox by id

function get_textBox_by_id($textBoxId) {
  $db = dbConnect();
  $sql = "SELECT * FROM textBox WHERE textBoxId = :textBoxId";
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':textBoxId', $textBoxId, PDO::PARAM_INT);
  $stmt->execute();
  $textBoxData = $stmt->fetchAll(PDO::FETCH_NAMED);
  $stmt->closeCursor();
  return $textBoxData;
}


function get_textBoxs_by_sectionId($projectId) {
  $db = dbConnect();
  $sql = "SELECT * FROM textBox WHERE projectId = :projectId";
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':projectId', $projectId, PDO::PARAM_STR);
  $stmt->execute();
  $textBoxData = $stmt->fetchAll(PDO::FETCH_NAMED);
  $stmt->closeCursor();
  return $textBoxData;
}




