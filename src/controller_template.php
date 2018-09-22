<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/include.php';

$template = new Controller('template');

// untested
$template->addAction('createtemplate', function($payload){

  // first think to do when creating a new action is to filter
  // the expected payload of that action.

  // Experamental function for filtering simple payloads
  $filterLoad = Controller::filterPayload($payload);

  // Second make sure that the required data is present
  if(empty($filterLoad['userId']) ||
    empty($filterLoad['templateStatus']) ||
    empty($filterLoad['templateTitle'])){
      return response("failure", "Not all required data was supplied for that template");
      exit;
  }

  // execute database model action
  $createtemplate = create_template($filterLoad);

  // check for success or failure
  if($createtemplate == 1) {
    // by sending a data response with a nested query we are able to imediately populate 
    // the template to the dashboard without having to make another request
    return dataResp("success", get_templates_by_userId($filterLoad['userId']), "template was successfully created");
  } else {
    return response("failure", "template died :(");
  }

}, TRUE);

// untested
$template->addAction('updatetemplate', function($payload){
  $filterLoad = Controller::filterPayload($payload);
  if(empty($filterLoad['userId']) ||
    empty($filterLoad['templateId']) ||
    empty($filterLoad['templateStatus']) ||
    empty($filterLoad['templateTitle'])){
      return response("failure", "Not all required data was supplied for that template");
      exit;
  }
  $updatetemplate = update_template($filterLoad);
  if($createtemplate == 1) {
    return dataResp("success", get_template_by_Id($filterLoad['templateId']), "template was successfully updated");
  } else {
    return response("failure", "template died :(");
  }
}, TRUE);

// untested
$template->addAction('deletetemplate', function($payload){
  $filterLoad = Controller::filterPayload($payload);
  if(empty($filterLoad['templateId'])) {
    return response("failure", "templateId was not specified");
    exit;
  }
  $deletetemplate = delete_template($filterLoad['templateId']);
  if($deletetemplate == 1) {
    return response("success", "template deleted successfully");
  } else {
    return response("failure", "Projuct was not deleted successfully");
  }
}, TRUE);
  
// untested
$template->addAction('gettemplateById', function($payload){
  $filterLoad = Controller::filterPayload($payload);
  if(empty($filterLoad['templateId'])){
    return response("failure", "No templateId was specified.");
    exit;
  }
  $templateData = get_template_by_id($filterLoad['templateId']);
  return dataResp("success", $templateData, "template Data was retrieved");
});

// untested
$template->addAction('gettemplatesByUserId', function($payload){
  $filterLoad = Controller::filterPayload($payload);
  if(empty($filterLoad['userId'])){
    return response("failure", "No userId was specified.");
    exit;
  }
  $templateData = get_templates_by_userId($filterLoad['userId']);
  return dataResp("success", $templateData, "templates were retrieved");
});