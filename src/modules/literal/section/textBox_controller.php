<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/include.php';

$textBox = new Controller('textBox');

// untested
$textBox->addAction('createTextBox', function($payload){

  $filterLoad = Controller::filterPayload($payload);

  // Second make sure that the required data is present
  if(empty($filterLoad['sectionId']) ||
    empty($filterLoad['textBoxText'])){
      return response("failure", "Not all required data was supplied for that textBox");
      exit;
  }

  // execute database model action
  $createTextBox = create_textBox($filterLoad);

  // check for success or failure
  if($createTextBox == 1) {
    // by sending a data response with a nested query we are able to imediately populate 
    // the textBox to the dashboard without having to make another request
    return dataResp("success", get_textBoxs_by_userId($filterLoad['userId']), "textBox was successfully created");
  } else {
    return response("failure", "textBox died :(");
  }

}, TRUE);

// untested
$textBox->addAction('updateTextBox', function($payload){
  $filterLoad = Controller::filterPayload($payload);
  if(empty($filterLoad['textBoxId']) ||
    empty($filterLoad['textBoxText'])){
      return response("failure", "Not all required data was supplied for that textBox");
      exit;
  }
  $updatetextBox = update_textBox($filterLoad);
  if($createtextBox == 1) {
    return dataResp("success", get_textBox_by_Id($filterLoad['textBoxId']), "textBox was successfully updated");
  } else {
    return response("failure", "textBox died :(");
  }
}, TRUE);

// untested
$textBox->addAction('deleteTextBox', function($payload){
  $filterLoad = Controller::filterPayload($payload);
  if(empty($filterLoad['textBoxId'])) {
    return response("failure", "textBoxId was not specified");
    exit;
  }
  $deletetextBox = delete_textBox($filterLoad['textBoxId']);
  if($deletetextBox == 1) {
    return response("success", "textBox deleted successfully");
  } else {
    return response("failure", "Projuct was not deleted successfully");
  }
}, TRUE);
  
// untested
$textBox->addAction('getTextBoxById', function($payload){
  $filterLoad = Controller::filterPayload($payload);
  if(empty($filterLoad['textBoxId'])){
    return response("failure", "No textBoxId was specified.");
    exit;
  }
  $textBoxData = get_textBox_by_id($filterLoad['textBoxId']);
  return dataResp("success", $textBoxData, "textBox Data was retrieved");
});

// untested
$textBox->addAction('getTextBoxsBySectionId', function($payload){
  $filterLoad = Controller::filterPayload($payload);
  if(empty($filterLoad['sectionId'])){
    return response("failure", "No userId was specified.");
    exit;
  }
  $textBoxData = get_textBoxs_by_userId($filterLoad['sectionId']);
  return dataResp("success", $textBoxData, "textBoxs were retrieved");
});