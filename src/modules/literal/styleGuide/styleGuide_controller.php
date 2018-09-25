<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/include.php';

$styleGuide = new Controller('styleGuide');

// Passing
$styleGuide->addAction('createStyleGuide', function($payload){

  // first think to do when creating a new action is to filter
  // the expected payload of that action.

  // Experamental function for filtering simple payloads
  $filterLoad = Controller::filterPayload($payload);

  // Second make sure that the required data is present
  if(empty($filterLoad['projectId']) ||
    empty($filterLoad['styleGuideStatus']) ||
    empty($filterLoad['styleGuideTitle'])){
      return response("failure", "Not all required data was supplied for that styleGuide");
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
    return response("failure", "styleGuide died :(");
  }

}, TRUE);

// untested
$styleGuide->addAction('updateStyleGuide', function($payload){
  $filterLoad = Controller::filterPayload($payload);
  if(empty($filterLoad['styleGuideId']) ||
    empty($filterLoad['styleGuideStatus']) ||
    empty($filterLoad['styleGuideTitle'])){
      return response("failure", "Not all required data was supplied for that styleGuide");
      exit;
  }
  $updateStyleGuide = update_styleGuide($filterLoad);
  if($updateStyleGuide == 1) {
    return dataResp("success", get_styleGuides_by_projectId($filterLoad['projectId']), "styleGuide was successfully updated");
  } else {
    return response("failure", "styleGuide died :(");
  }
}, TRUE);

// untested
$styleGuide->addAction('deleteStyleGuide', function($payload){
  $filterLoad = Controller::filterPayload($payload);
  if(empty($filterLoad['styleGuideId'])) {
    return response("failure", "styleGuideId was not specified");
    exit;
  }
  $deletestyleGuide = delete_styleGuide($filterLoad['styleGuideId']);
  if($deletestyleGuide == 1) {
    return response("success", "styleGuide deleted successfully");
  } else {
    return response("failure", "Projuct was not deleted successfully");
  }
}, TRUE);
  
// untested
$styleGuide->addAction('getStyleGuideById', function($payload){
  $filterLoad = Controller::filterPayload($payload);
  if(empty($filterLoad['styleGuideId'])){
    return response("failure", "No styleGuideId was specified.");
    exit;
  }
  $styleGuideData = get_styleGuide_by_id($filterLoad['styleGuideId']);
  return dataResp("success", $styleGuideData, "styleGuide Data was retrieved");
});

// Passing
$styleGuide->addAction('getStyleGuidesByProjectId', function($payload){
  $filterLoad = Controller::filterPayload($payload);
  if(empty($filterLoad['projectId'])){
    return response("failure", "No projectId was specified.");
    exit;
  }
  $styleGuideData = get_styleGuides_by_userId($filterLoad['projectId']);
  return dataResp("success", $styleGuideData, "styleGuides were retrieved");
});