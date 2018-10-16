<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/include.php';

$textBox = new Controller('textBox');

$textBox->addAction('createTextBox', function($payload){
  $filterLoad = Controller::filterPayload($payload);
  Controller::required(['sectionId', 'itemOrder'], $filterLoad);

  $createItem = create_textBox($filterLoad);
  if($createItem == 1) {
    $sectionItems = Section::getSectionItems($filterLoad['sectionId']);
    return Response::data($sectionItems, 'section Items retrieved');
  } else {
    return Response::err("section Item was not created successfully");
  }
}, TRUE);

$textBox->addAction('updateTextBox', function($payload){
  // var_dump($payload);
  // exit;
  $filterLoad = Controller::filterPayload($payload);
  Controller::required(['sectionId', 'textBoxId'], $filterLoad);
  $updateTextBox = update_textBox($filterLoad);
  if($updateTextBox == 1) {
    $sectionItems = Section::getSectionItems($filterLoad['sectionId']);
    return Response::data($sectionItems, 'section Items retrieved');
  } else {
    return Response::err("section Item was not created successfully");
  }
}, TRUE);

$textBox->addAction('deleteTextBox', function($payload){
  $filterLoad = Controller::filterPayload($payload);
  Controller::required(['textBoxId', 'sectionId'], $filterLoad);
  $deleteTextBox = delete_textBox($filterLoad);
  if($deleteTextBox == 1) {
    $sectionItems = Section::getSectionItems($filterLoad['sectionId']);
    return Response::data($sectionItems, 'section Items retrieved');
  } else {
    return response('failure', "section Item was not created successfully");
  }
}, TRUE);

$textBox->addAction('getTextBoxById', function($payload){
  $filterLoad = Controller::filterPayload($payload);
  if(empty($filterLoad['textBoxId'])){
    return response("failure", "No __Id specified");
  }
  $sectionItem = get_exam_by_id($filterLoad['textBoxId']);
}, TRUE);