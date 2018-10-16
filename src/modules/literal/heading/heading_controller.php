<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/include.php';

$heading = new Controller('heading');

$heading->addAction('createHeading', function($payload){
  $filterLoad = Controller::filterPayload($payload);
  Controller::required(['sectionId', 'itemOrder'], $filterLoad);

  $createItem = create_heading($filterLoad);
  if($createItem == 1) {
    $sectionItems = Section::getSectionItems($filterLoad['sectionId']);
    return Response::data($sectionItems, 'section Items retrieved');
  } else {
    return Response::err("section Item was not created successfully");
  }
}, TRUE);

$heading->addAction('updateHeading', function($payload){
  $filterLoad = Controller::filterPayload($payload);
  Controller::required(['sectionId', 'headingId'], $filterLoad);
  $updateHeading = update_heading($filterLoad);
  if($updateHeading == 1) {
    $sectionItems = Section::getSectionItems($filterLoad['sectionId']);
    return Response::data($sectionItems, 'section Items retrieved');
  } else {
    return Response::err("section Item was not updated successfully");
  }
}, TRUE);

$heading->addAction('deleteHeading', function($payload){
  $filterLoad = Controller::filterPayload($payload);
  Controller::required(['headingId', 'sectionId'], $filterLoad);
  $deleteHeading = delete_heading($filterLoad);
  if($deleteHeading == 1) {
    $sectionItems = Section::getSectionItems($filterLoad['sectionId']);
    return Response::data($sectionItems, 'section Items retrieved');
  } else {
    return response('failure', "section Item was not created successfully");
  }
}, TRUE);

$heading->addAction('getHeadingById', function($payload){
  $filterLoad = Controller::filterPayload($payload);
  if(empty($filterLoad['headingId'])){
    return response("failure", "No __Id specified");
  }
  $sectionItem = get_exam_by_id($filterLoad['headingId']);
}, TRUE);