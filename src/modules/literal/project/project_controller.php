<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/include.php';

/**
 * Project
 *  
 *  Projects are entities that user creates that
 *  can can have different items appended to them
 *  they could be a brand an applicaiton or any
 *  other item requiring a style guide
 */

$project = new Controller('project');

/**
 * Create Project // passing
 * --------------
 * 
 *  Requires:
 *  @var userId 
 *  @var projectStatus
 *  @var projectTitle
 */

$project->addAction('createProject', 

  function($payload){

    $filterLoad = Controller::filterPayload($payload);
                  Controller::required(['userId', 'projectStatus', 'projectTitle'], $filterLoad);

    $createProject = create_project($filterLoad);

    if($createProject == 1) {
      return Response::data(get_projects_by_userId($filterLoad['userId']), "project was successfully created");
    } else {
      return Response::err("project died :(");
    }

  }, TRUE);

  /**
 * Update Project // passing
 * --------------
 * 
 *  Requires:
 *  @var userId 
 *  @var projectId
 *  @var projectStatus
 *  @var projectTitle
 */

$project->addAction('updateProject', 

  function($payload){

    $filterLoad = Controller::filterPayload($payload);
                  Controller::required(['userId', 'projectId', 'projectStatus', 'projectTitle'], $filterLoad);

    $updateProject = update_project($filterLoad);

    if($updateProject == 1) {
      return Response::data(get_projects_by_userId($filterLoad['userId']), "project was successfully updated");
    } else {
      return Response::err("project died :(");
    }

}, TRUE);

/**
 * Delete Project // passing
 * --------------
 * 
 *  Requires:
 *  @var projectId 
 */

$project->addAction('deleteProject', 
  function($payload){
    $filterLoad = Controller::filterPayload($payload);
                  Controller::required(['projectId'], $filterLoad);

    $deleteProject = delete_project($filterLoad['projectId']);

    if($deleteProject == 1) {
      return Response::data(get_projects_by_userId($filterLoad['userId']), "Project deleted successfully");
    } else {
      return Response::err("Projuct was not deleted successfully");
    }
}, TRUE);

/**
 * Get Project By Id // passing
 * --------------
 * 
 *  Requires:
 *  @var projectId 
 */
  
$project->addAction('getProjectById', 

  function($payload){

    $filterLoad = Controller::filterPayload($payload);
                  Controller::required(['projectId'], $filterLoad);

    $projectData = get_project_by_id($filterLoad['projectId']);
    $styleGuideData = get_styleGuides_by_projectId($filterLoad['projectId']);
    $resData = [$projectData, $styleGuideData];
    return Response::data($resData, "Project Data was retrieved");
});

/**
 * Get Projects By User Id // passing
 * --------------
 * 
 *  Requires:
 *  @var userId 
 */

$project->addAction('getProjectsByUserId', function($payload){
  $filterLoad = Controller::filterPayload($payload);
                Controller::required(['userId'], $filterLoad);
  $projectData = get_projects_by_userId($filterLoad['userId']);
  return Response::data($projectData, "Projects were retrieved");
});