<?php 


// create project
function create_project($projectData) {
  $db = dbConnect();
  $sql = 'INSERT INTO project (projectTitle, projectStatus, userId) VALUES (:projectTitle, :projectStatus, :userId)';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':projectTitle',   $projectData['projectTitle'],   PDO::PARAM_STR);
  $stmt->bindValue(':projectStatus',  $projectData['projectStatus'],  PDO::PARAM_STR);
  $stmt->bindValue(':userId',         $projectData['userId'],         PDO::PARAM_INT);
  $stmt->execute();
  $rowsChanged = $stmt->rowCount();
  $stmt->closeCursor();
  return $rowsChanged;
}


function update_project($projectData) {
  $db = dbConnect();
  $sql = 'UPDATE project SET projectTitle = :projectTitle, projectDescription = :projectDescription,  projectStatus= :projectStatus WHERE projectId = :projectId';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':projectTitle',   $projectData['projectTitle'],   PDO::PARAM_STR);
  $stmt->bindValue(':projectDescription', $projectData['projectDescription'], PDO::PARAM_STR);
  $stmt->bindValue(':projectStatus',  $projectData['projectStatus'],  PDO::PARAM_STR);
  $stmt->bindValue(':projectId',      $projectData['projectId'],      PDO::PARAM_INT);
  $stmt->execute();
  $rowsChanged = $stmt->rowCount();
  $stmt->closeCursor();
  return $rowsChanged;
}

function update_project_status($projectData) {
  $db = dbConnect();
  $sql = 'UPDATE project SET projectStatus= :projectStatus, projectModified = :projectModified WHERE projectId = :projectId';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':projectStatus',  $projectData['projectStatus'],  PDO::PARAM_STR);
  $stmt->bindValue(':projectModified',$projectData['projectModified'],PDO::PARAM_STR);
  $stmt->bindValue(':projectId',      $projectData['projectId'],      PDO::PARAM_INT);
  $stmt->execute();
  $rowsChanged = $stmt->rowCount();
  $stmt->closeCursor();
  return $rowsChanged;
}

// delete project

function delete_project($projectId) {
  $db = dbConnect();
  $sql = 'DELETE FROM project WHERE projectId = :projectId';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':projectId', $projectId, PDO::PARAM_INT);
  $stmt->execute();
  $rowsChanged = $stmt->rowCount();
  $stmt->closeCursor();
  return $rowsChanged;
}

// get project by id

function get_project_by_id($projectId) {
  $db = dbConnect();
  $sql = "SELECT * FROM project WHERE projectId = :projectId";
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':projectId', $projectId, PDO::PARAM_INT);
  $stmt->execute();
  $projectData = $stmt->fetchAll(PDO::FETCH_NAMED);
  $stmt->closeCursor();
  return $projectData;
}

// get project by name

function get_project_by_title($projectTitle) {
  $db = dbConnect();
  $sql = "SELECT project.*, asset.*  FROM project
          LEFT JOIN asset_assignment AS aa ON project.projectId = aa.projectId
          LEFT JOIN asset ON aa.assetId = asset.assetId
          WHERE projectTitle = :projectTitle";
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':projectTitle', $projectTitle, PDO::PARAM_STR);
  $stmt->execute();
  $projectData = $stmt->fetchAll(PDO::FETCH_NAMED);
  $stmt->closeCursor();
  return $projectData;
}

// get all projects

function get_projects() {
  $db = dbConnect();
  $sql = "SELECT project.*, asset.*  FROM project
          LEFT JOIN asset_assignment AS aa ON project.projectId = aa.projectId
          LEFT JOIN asset ON aa.assetId = asset.assetId
          ORDER BY projectCreated ASC";
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $projectData = $stmt->fetchAll(PDO::FETCH_NAMED);
  $stmt->closeCursor();
  return $projectData;
}

function get_published_projects () {
  $db = dbConnect();
  $sql = "SELECT project.*, asset.*  FROM project
          LEFT JOIN asset_assignment AS aa ON project.projectId = aa.projectId
          LEFT JOIN asset ON aa.assetId = asset.assetId
          WHERE projectStatus = 'published'
          ORDER BY projectCreated DESC";
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $projectData = $stmt->fetchAll(PDO::FETCH_NAMED);
  $stmt->closeCursor();
  return $projectData;
}

function get_projects_by_userId($userId) {
  $db = dbConnect();
  $sql = "SELECT * FROM project WHERE userId = :userId";
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':userId', $userId, PDO::PARAM_STR);
  $stmt->execute();
  $projectData = $stmt->fetchAll(PDO::FETCH_NAMED);
  $stmt->closeCursor();
  return $projectData;
}


// get variable projects
// Implement the number here
function get_number_of_projects($numberOfprojects) {
  $db = dbConnect();
  $sql = "SELECT project.*, asset.*  FROM project
          LEFT JOIN asset_assignment AS aa ON project.projectId = aa.projectId
          LEFT JOIN asset ON aa.assetId = asset.assetId
          ORDER BY projectCreated DESC LIMIT " . $numberOfprojects;
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $stmt->closeCursor();
  return $projects;
}

function get_number_of_published_projects($numberOfprojects) {
  $db = dbConnect();
  $sql = "SELECT project.*, asset.*  FROM project
          LEFT JOIN asset_assignment AS aa ON project.projectId = aa.projectId
          LEFT JOIN asset ON aa.assetId = asset.assetId
          WHERE projectStatus = 'published'
          ORDER BY projectCreated DESC LIMIT " . $numberOfprojects;
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $stmt->closeCursor();
  return $projects;
}