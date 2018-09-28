<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/include.php';

$project = new Controller('project');

// passing
$project->addAction('createProject', function($payload){

  // first think to do when creating a new action is to filter
  // the expected payload of that action.

  // Experamental function for filtering simple payloads
  $filterLoad = Controller::filterPayload($payload);

  // Second make sure that the required data is present
  if(empty($filterLoad['userId']) ||
    empty($filterLoad['projectStatus']) ||
    empty($filterLoad['projectTitle'])){
      return Response::err("Not all required data was supplied for that project");
      exit;
  }

  // execute database model action
  $createProject = create_project($filterLoad);

  // check for success or failure
  if($createProject == 1) {
    // by sending a data response with a nested query we are able to imediately populate 
    // the project to the dashboard without having to make another request
    return Response::data(get_projects_by_userId($filterLoad['userId']), "project was successfully created");
  } else {
    return Response::err("project died :(");
  }

}, TRUE);

// untested
$project->addAction('updateProject', function($payload){
  $filterLoad = Controller::filterPayload($payload);
  if(empty($filterLoad['userId']) ||
    empty($filterLoad['projectId']) ||
    empty($filterLoad['projectStatus']) ||
    empty($filterLoad['projectTitle'])){
      return Response::err("Projuct was not deleted successfully");
      exit;
  }
  $updateProject = update_project($filterLoad);
  if($updateProject == 1) {
    return Response::data(get_projects_by_userId($filterLoad['userId']), "project was successfully updated");
  } else {
    return Response::err("project died :(");
  }
}, TRUE);

// Passing
$project->addAction('deleteProject', function($payload){
  $filterLoad = Controller::filterPayload($payload);
  if(empty($filterLoad['projectId'])) {
    return Response::err("projectId was not specified");
    exit;
  }
  $deleteProject = delete_project($filterLoad['projectId']);
  if($deleteProject == 1) {
    return Response::data(get_projects_by_userId($filterLoad['userId']), "Project deleted successfully");
  } else {
    return Response::err("Projuct was not deleted successfully");
  }
}, TRUE);
  
// passing
$project->addAction('getProjectById', function($payload){
  $filterLoad = Controller::filterPayload($payload);
  if(empty($filterLoad['projectId'])){
    return Response::err("No projectId was specified.");
    exit;
  }
  $projectData = get_project_by_id($filterLoad['projectId']);
  $styleGuideData = get_styleGuides_by_projectId($filterLoad['projectId']);
  $resData = [$projectData, $styleGuideData];
  return Response::data($resData, "Project Data was retrieved");
});

// passing
$project->addAction('getProjectsByUserId', function($payload){
  $filterLoad = Controller::filterPayload($payload);
  if(empty($filterLoad['userId'])){
    return Response::err("No userId was specified.");
    exit;
  }
  $projectData = get_projects_by_userId($filterLoad['userId']);
  return Response::data($projectData, "Projects were retrieved");
});