<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/include.php';

$styleGuide = new Controller('styleGuide');

// Passing
$styleGuide->addAction('createStyleGuide', function($payload){

  // first thing to do when creating a new action is to filter
  // the expected payload of that action.

  // Experamental function for filtering simple payloads
  $filterLoad = Controller::filterPayload($payload);

  // Second make sure that the required data is present
  if(empty($filterLoad['projectId']) ||
    empty($filterLoad['styleGuideStatus']) ||
    empty($filterLoad['styleGuideTitle'])){
      return Response::err("Not all required data was supplied for that styleGuide");
      exit;
  }

  // execute database model action
  $createstyleGuide = create_styleGuide($filterLoad);

  // check for success or failure
  if($createstyleGuide == 1) {
    // by sending a data response with a nested query we are able to imediately populate 
    // the styleGuide to the dashboard without having to make another request
    return dataResp("success", get_styleGuides_by_projectId($filterLoad['projectId']), "styleGuide was successfully created");
  } else {
    return Response::err("styleGuide died :(");
  }

}, TRUE);

// Passing
$styleGuide->addAction('updateStyleGuide', function($payload){
  $filterLoad = Controller::filterPayload($payload);
  if(empty($filterLoad['styleGuideId']) ||
    empty($filterLoad['styleGuideStatus']) ||
    empty($filterLoad['styleGuideTitle'])){
      return Response::err("Not all required data was supplied for that styleGuide");
      exit;
  }
  $updateStyleGuide = update_styleGuide($filterLoad);
  if($updateStyleGuide == 1) {
    return dataResp("success", get_styleGuides_by_projectId($filterLoad['projectId']), "styleGuide was successfully updated");
  } else {
    return Response::err("styleGuide died :(");
  }
}, TRUE);

// Passing
$styleGuide->addAction('deleteStyleGuide', function($payload){
  $filterLoad = Controller::filterPayload($payload);
  if(empty($filterLoad['styleGuideId']) ||
     empty($filterLoad['projectId'])) {
    return Response::err("styleGuideId was not specified");
    exit;
  }
  $deleteStyleGuide = delete_styleGuide($filterLoad['styleGuideId']);
  if($deleteStyleGuide == 1) {
    return Response::data(get_styleGuides_by_projectId($filterLoad['projectId']),"styleGuide deleted successfully");
  } else {
    return Response::err("styleGuide was not deleted successfully");
  }
}, TRUE);
  
// untested
$styleGuide->addAction('getStyleGuideById', function($payload){
  $filterLoad = Controller::filterPayload($payload);
  if(empty($filterLoad['styleGuideId'])){
    return Response::err("No styleGuideId was specified.");
    exit;
  }
  $styleGuideData = get_styleGuide_by_id($filterLoad['styleGuideId']);
  $sectionData = get_sections_by_styleGuideId($filterLoad['styleGuideId']);
  $respData = [$styleGuideData, $sectionData];
  return dataResp("success", $respData, "styleGuide Data was retrieved");
});

// Passing
$styleGuide->addAction('getStyleGuidesByProjectId', function($payload){
  $filterLoad = Controller::filterPayload($payload);
  if(empty($filterLoad['projectId'])){
    return Response::err("No projectId was specified.");
    exit;
  }
  $styleGuideData = get_styleGuides_by_userId($filterLoad['projectId']);
  return dataResp("success", $styleGuideData, "styleGuides were retrieved");
});