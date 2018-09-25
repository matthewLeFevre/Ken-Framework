<?php 


// create styleGuide
function create_styleGuide($styleGuideData) {
  $db = dbConnect();
  $sql = 'INSERT INTO styleGuide (styleGuideTitle, styleGuideStatus, projectId) VALUES (:styleGuideTitle, :styleGuideStatus, :projectId)';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':styleGuideTitle',   $styleGuideData['styleGuideTitle'],   PDO::PARAM_STR);
  $stmt->bindValue(':styleGuideStatus',  $styleGuideData['styleGuideStatus'],  PDO::PARAM_STR);
  $stmt->bindValue(':projectId',         $styleGuideData['projectId'],         PDO::PARAM_INT);
  $stmt->execute();
  $rowsChanged = $stmt->rowCount();
  $stmt->closeCursor();
  return $rowsChanged;
}
// update styleGuide
// - add like
// - add share

function update_styleGuide($styleGuideData) {
  $db = dbConnect();
  $sql = 'UPDATE styleGuide SET styleGuideTitle = :styleGuideTitle, styleGuideDescription = :styleGuideDescription, styleGuideStatus= :styleGuideStatus WHERE styleGuideId = :styleGuideId';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':styleGuideTitle',   $styleGuideData['styleGuideTitle'],   PDO::PARAM_STR);
  $stmt->bindValue(':styleGuideDescription', $styleGuideData['styleGuideDescription'], PDO::PARAM_STR);
  $stmt->bindValue(':styleGuideStatus',  $styleGuideData['styleGuideStatus'],  PDO::PARAM_STR);
  $stmt->bindValue(':styleGuideId',      $styleGuideData['styleGuideId'],      PDO::PARAM_INT);
  $stmt->execute();
  $rowsChanged = $stmt->rowCount();
  $stmt->closeCursor();
  return $rowsChanged;
}

function update_styleGuide_status($styleGuideData) {
  $db = dbConnect();
  $sql = 'UPDATE styleGuide SET styleGuideStatus= :styleGuideStatus, styleGuideModified = :styleGuideModified WHERE styleGuideId = :styleGuideId';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':styleGuideStatus',  $styleGuideData['styleGuideStatus'],  PDO::PARAM_STR);
  $stmt->bindValue(':styleGuideModified',$styleGuideData['styleGuideModified'],PDO::PARAM_STR);
  $stmt->bindValue(':styleGuideId',      $styleGuideData['styleGuideId'],      PDO::PARAM_INT);
  $stmt->execute();
  $rowsChanged = $stmt->rowCount();
  $stmt->closeCursor();
  return $rowsChanged;
}

// delete styleGuide

function delete_styleGuide($styleGuideId) {
  $db = dbConnect();
  $sql = 'DELETE FROM styleGuide WHERE styleGuideId = :styleGuideId';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':styleGuideId', $styleGuideId, PDO::PARAM_INT);
  $stmt->execute();
  $rowsChanged = $stmt->rowCount();
  $stmt->closeCursor();
  return $rowsChanged;
}

// get styleGuide by id

function get_styleGuide_by_id($styleGuideId) {
  $db = dbConnect();
  $sql = "SELECT * FROM styleGuide WHERE styleGuideId = :styleGuideId";
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':styleGuideId', $styleGuideId, PDO::PARAM_INT);
  $stmt->execute();
  $styleGuideData = $stmt->fetchAll(PDO::FETCH_NAMED);
  $stmt->closeCursor();
  return $styleGuideData;
}

// get styleGuide by name

function get_styleGuide_by_title($styleGuideTitle) {
  $db = dbConnect();
  $sql = "SELECT styleGuide.*, asset.*  FROM styleGuide
          LEFT JOIN asset_assignment AS aa ON styleGuide.styleGuideId = aa.styleGuideId
          LEFT JOIN asset ON aa.assetId = asset.assetId
          WHERE styleGuideTitle = :styleGuideTitle";
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':styleGuideTitle', $styleGuideTitle, PDO::PARAM_STR);
  $stmt->execute();
  $styleGuideData = $stmt->fetchAll(PDO::FETCH_NAMED);
  $stmt->closeCursor();
  return $styleGuideData;
}

// get all styleGuides

function get_styleGuides() {
  $db = dbConnect();
  $sql = "SELECT styleGuide.*, asset.*  FROM styleGuide
          LEFT JOIN asset_assignment AS aa ON styleGuide.styleGuideId = aa.styleGuideId
          LEFT JOIN asset ON aa.assetId = asset.assetId
          ORDER BY styleGuideCreated ASC";
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $styleGuideData = $stmt->fetchAll(PDO::FETCH_NAMED);
  $stmt->closeCursor();
  return $styleGuideData;
}

function get_published_styleGuides () {
  $db = dbConnect();
  $sql = "SELECT styleGuide.*, asset.*  FROM styleGuide
          LEFT JOIN asset_assignment AS aa ON styleGuide.styleGuideId = aa.styleGuideId
          LEFT JOIN asset ON aa.assetId = asset.assetId
          WHERE styleGuideStatus = 'published'
          ORDER BY styleGuideCreated DESC";
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $styleGuideData = $stmt->fetchAll(PDO::FETCH_NAMED);
  $stmt->closeCursor();
  return $styleGuideData;
}

function get_styleGuides_by_projectId($projectId) {
  $db = dbConnect();
  $sql = "SELECT * FROM styleGuide WHERE projectId = :projectId";
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':projectId', $projectId, PDO::PARAM_STR);
  $stmt->execute();
  $styleGuideData = $stmt->fetchAll(PDO::FETCH_NAMED);
  $stmt->closeCursor();
  return $styleGuideData;
}


// get variable styleGuides
// Implement the number here
function get_number_of_styleGuides($numberOfstyleGuides) {
  $db = dbConnect();
  $sql = "SELECT styleGuide.*, asset.*  FROM styleGuide
          LEFT JOIN asset_assignment AS aa ON styleGuide.styleGuideId = aa.styleGuideId
          LEFT JOIN asset ON aa.assetId = asset.assetId
          ORDER BY styleGuideCreated DESC LIMIT " . $numberOfstyleGuides;
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $styleGuides = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $stmt->closeCursor();
  return $styleGuides;
}

function get_number_of_published_styleGuides($numberOfstyleGuides) {
  $db = dbConnect();
  $sql = "SELECT styleGuide.*, asset.*  FROM styleGuide
          LEFT JOIN asset_assignment AS aa ON styleGuide.styleGuideId = aa.styleGuideId
          LEFT JOIN asset ON aa.assetId = asset.assetId
          WHERE styleGuideStatus = 'published'
          ORDER BY styleGuideCreated DESC LIMIT " . $numberOfstyleGuides;
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $styleGuides = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $stmt->closeCursor();
  return $styleGuides;
}