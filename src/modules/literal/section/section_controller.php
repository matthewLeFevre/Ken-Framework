<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/include.php';

$section = new Controller('section');

// untested
$section->addAction('createSection', function($payload){

  // first think to do when creating a new action is to filter
  // the expected payload of that action.

  // Experamental function for filtering simple payloads
  $filterLoad = Controller::filterPayload($payload);

  // Second make sure that the required data is present
  if(empty($filterLoad['userId']) ||
    empty($filterLoad['styleGuideId']) ||
    empty($filterLoad['order']) ||
    empty($filterLoad['sectionTitle'])){
      return response("failure", "Not all required data was supplied for that section");
      exit;
  }

  // execute database model action
  $createsection = create_section($filterLoad);

  // check for success or failure
  if($createsection == 1) {
    // by sending a data response with a nested query we are able to imediately populate 
    // the section to the dashboard without having to make another request
    return dataResp("success", get_sections_by_userId($filterLoad['userId']), "section was successfully created");
  } else {
    return response("failure", "section died :(");
  }

}, TRUE);

// untested
$section->addAction('updateSection', function($payload){
  $filterLoad = Controller::filterPayload($payload);
  if(empty($filterLoad['userId']) ||
    empty($filterLoad['order']) ||
    empty($filterLoad['sectionId']) ||
    empty($filterLoad['sectionTitle'])){
      return response("failure", "Not all required data was supplied for that section");
      exit;
  }
  $updatesection = update_section($filterLoad);
  if($createsection == 1) {
    return dataResp("success", get_section_by_Id($filterLoad['sectionId']), "section was successfully updated");
  } else {
    return response("failure", "section died :(");
  }
}, TRUE);

// untested
$section->addAction('deleteSection', function($payload){
  $filterLoad = Controller::filterPayload($payload);
  if(empty($filterLoad['sectionId'])) {
    return response("failure", "sectionId was not specified");
    exit;
  }
  $deletesection = delete_section($filterLoad['sectionId']);
  if($deletesection == 1) {
    return response("success", "section deleted successfully");
  } else {
    return response("failure", "Projuct was not deleted successfully");
  }
}, TRUE);
  
// untested
$section->addAction('getSectionById', function($payload){
  $filterLoad = Controller::filterPayload($payload);
  if(empty($filterLoad['sectionId'])){
    return response("failure", "No sectionId was specified.");
    exit;
  }
  $sectionData = get_section_by_id($filterLoad['sectionId']);
  return dataResp("success", $sectionData, "section Data was retrieved");
});

// untested
$section->addAction('getSectionsByUserId', function($payload){
  $filterLoad = Controller::filterPayload($payload);
  if(empty($filterLoad['userId'])){
    return response("failure", "No userId was specified.");
    exit;
  }
  $sectionData = get_sections_by_userId($filterLoad['userId']);
  return dataResp("success", $sectionData, "sections were retrieved");
}, TRUE);

// untested
$section->addAction('getSectionsByStyleGuideId', function($payload){
  $filterLoad = Controller::filterPayload($payload);
  if(empty($filterLoad['styleGuideId'])){
    return response("failure", "No projectId was specified.");
    exit;
  }
  $sectionData = get_sections_by_userId($filterLoad['styleGuideId']);
  return dataResp("success", $sectionData, "sections were retrieved");
});