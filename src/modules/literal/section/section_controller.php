<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/include.php';

$section = new Controller('section');
/**
 * Section actions
 */

// passing
$section->addAction('createSection', function($payload){

  $filterLoad = Controller::filterPayload($payload);
  Controller::required(['styleGuideId', 'itemOrder', 'sectionTitle'], $filterLoad);

  // execute database model action
  $createSection = create_section($filterLoad);

  // check for success or failure
  if($createSection == 1) {
    // by sending a data response with a nested query we are able to imediately populate 
    // the section to the dashboard without having to make another request
    return Response::data(get_sections_by_styleGuideId($filterLoad['styleGuideId']), "section was successfully created");
  } else {
    return Response::err("section died :( on querey to create");
  }

}, TRUE);

// passing
$section->addAction('updateSection', function($payload){
  $filterLoad = Controller::filterPayload($payload);
  Controller::required(['userId', 'itemOrder', 'sectionId', 'sectionTitle'], $filterLoad);
  
  $updateSection = update_section($filterLoad);
  if($updateSection == 1) {
    return Response::data(get_section_by_Id($filterLoad['sectionId']), "section was successfully updated");
  } else {
    return Response::err("section died :( when queryed to update.");
  }
}, TRUE);

// untested
$section->addAction('updateSectionAndItems', function($payload){

  foreach($payload['items'] as $item) {
    switch($item['itemType']) {
      case 'heading':
        $section->callAction('updatHeading', $item);
        break;
      case 'textbox':
        $section->callAction('updateTextBox', $item);
        break;
      case 'font':
        $section->callAction('updateFont', $item);
        break;
      case 'image':
        $section->callAction('updateImage', $item);
        break;
      case 'component':
        $section->callAction('updateComponent', $item);
        break;
    }
  }

  $filterLoad = Controller::filterPayload($payload['section']);
  Controller::required(['userId', 'itemOrder', 'sectionId', 'sectionTitle'], $filterLoad);

  $updateSection = update_section($filterLoad);
  if($updateSection == 1) {
    $section->callAction('getSectionAndItemsBySectionId', $filterLoad['sectionId']);
  } else {
    return Response::err("section died :(");
  }
}, TRUE);

// untested
$section->addAction('deleteSection', function($payload){
  $filterLoad = Controller::filterPayload($payload);
  Controller::required(['sectionId'], $filterLoad);
  $deletesection = delete_section($filterLoad['sectionId']);
  if($deletesection == 1) {
    return Response::data(get_sections_by_styleGuideId($filterLoad['styleGuideId']));
  } else {
    return Response::err("Project was not deleted successfully");
  }
}, TRUE);
  
// untested
$section->addAction('getSectionById', function($payload){
  $filterLoad = Controller::filterPayload($payload);
  Controller::required(['sectionId'], $filterLoad);
  
  $sectionData = get_section_by_id($filterLoad['sectionId']);
  return Response::data($sectionData, "section Data was retrieved");
});

// untested - possibly is uneeded
$section->addAction('getSectionsByUserId', function($payload){
  $filterLoad = Controller::filterPayload($payload);
  Controller::required(['userId'], $filterLoad);

  $sectionData = get_sections_by_userId($filterLoad['userId']);
  return Response::data($sectionData, "sections were retrieved");
}, TRUE);

// untested
$section->addAction('getSectionsByStyleGuideId', function($payload){
  $filterLoad = Controller::filterPayload($payload);
  Controller::required(['styleGuideId'], $filterLoad);

  $sectionData = get_sections_by_styleGuideId($filterLoad['styleGuideId']);
  array_multisort(array_column($sectionData, 'itemOrder'), SORT_ASC, SORT_NUMERIC, $sectionData);
  return Response::data($sectionData, "sections were retrieved");
});

//untested
$section->addAction('getSectionAndItemsBySectionId', function($payload){
  $filterLoad = Controller::filterPayload($payload);
                Controller::required(['sectionId'], $filterLoad);
  $sectionItems = Section::getSectionItems($filterLoad['sectionId']);
  $section = get_section_by_id($filterLoad['sectionId']);
  $sectionData = array("section" => $section, "items" => $sectionItems);

  return Response::data($sectionData, "Section and all items were retrieved.");
});

/**
 * Section Item Create Actions
 */



$section->addAction('createHeading', function($payload){
  $filterLoad = Controller::filterPayload($payload);
  Controller::required(['sectionId', 'itemOrder'], $filterLoad);

  $createItem = create_heading($filterLoad);
  if($createItem == 1) {
    $section->callAction('getSectionAndItemsBySectionId', $filterLoad['sectionId']);
  } else {
    return response('failure', "section Item was not created successfully");
  }

}, TRUE);

$section->addAction('createFont', function($payload){
  $filterLoad = Controller::filterPayload($payload);
  if(empty($filterLoad['sectionId']) ||
     empty($filterLoad['itemOrder'])){
    return response("failure", "Not all data was supplied for this item.");
  }

  $createItem = create_font($filterLoad);
  if($createItem == 1) {
    $section->callAction('getSectionAndItemsBySectionId', $filterLoad['sectionId']);
  } else {
    return response('failure', "section Item was not created successfully");
  }

}, TRUE);

$section->addAction('createImage', function($payload){
  $filterLoad = Controller::filterPayload($payload);
  if(empty($filterLoad['sectionId']) ||
     empty($filterLoad['itemOrder'])){
    return response("failure", "Not all data was supplied for this item.");
  }

  $createItem = create_image($filterLoad);
  if($createItem == 1) {
    $section->callAction('getSectionAndItemsBySectionId', $filterLoad['sectionId']);
  } else {
    return response('failure', "section Item was not created successfully");
  }

}, TRUE);

$section->addAction('createColorPallet', function($payload){
  $filterLoad = Controller::filterPayload($payload);
  if(empty($filterLoad['sectionId']) ||
     empty($filterLoad['itemOrder'])){
    return response("failure", "Not all data was supplied for this item.");
  }

  $createItem = create_colorPallet($filterLoad);
  if($createItem == 1) {
    $section->callAction('getSectionAndItemsBySectionId', $filterLoad['sectionId']);
  } else {
    return response('failure', "section Item was not created successfully");
  }

}, TRUE);

$section->addAction('createColorGroup', function($payload){
  $filterLoad = Controller::filterPayload($payload);
  if(empty($filterLoad['sectionId']) ||
     empty($filterLoad['colorPalletId']) ||
     empty($filterLoad['itemOrder'])){
    return response("failure", "Not all data was supplied for this item.");
  }

  $createItem = create_colorGroup($filterLoad);
  if($createItem == 1) {
    $section->callAction('getSectionAndItemsBySectionId', $filterLoad['sectionId']);
  } else {
    return response('failure', "section Item was not created successfully");
  }

}, TRUE);

$section->addAction('createColorSwatch', function($payload){
  $filterLoad = Controller::filterPayload($payload);
  if(empty($filterLoad['sectionId']) ||
     empty($filterLoad['colorGroupId']) ||
     empty($filterLoad['itemOrder'])){
    return response("failure", "Not all data was supplied for this item.");
  }

  $createItem = create_colorSwatch($filterLoad);
  if($createItem == 1) {
    $section->callAction('getSectionAndItemsBySectionId', $filterLoad['sectionId']);
  } else {
    return response('failure', "section Item was not created successfully");
  }

}, TRUE);

/**
 * Section Item Update Actions
 */



$section->addAction('updateHeading', function($payload){
  $filterLoad = Controller::filterPayload($payload);
  if(empty($filterLoad['sectionId']) || 
     empty($filterLoad['headingId'])  ||
     empty($filterLoad['itemOrder'])) {
    return response("failure", "No __Id specified");
  }
}, TRUE);

$section->addAction('updateFont', function($payload){
  $filterLoad = Controller::filterPayload($payload);
  if(empty($filterLoad['sectionId']) || 
     empty($filterLoad['fontId']) ||
     empty($filterLoad['itemOrder'])) {
    return response("failure", "No __Id specified");
  }
}, TRUE);

$section->addAction('updateImage', function($payload){
  $filterLoad = Controller::filterPayload($payload);
  if(empty($filterLoad['sectionId']) || 
     empty($filterLoad['imageId']) ||
     empty($filterLoad['itemOrder'])) {
    return response("failure", "No __Id specified");
  }
}, TRUE);

$section->addAction('updateColorPallet', function($payload){
  $filterLoad = Controller::filterPayload($payload);
  if(empty($filterLoad['sectionId']) || 
     empty($filterLoad['colorPalletId']) ||
     empty($filterLoad['itemOrder'])) {
    return response("failure", "No __Id specified");
  }
}, TRUE);

$section->addAction('updateColorGroup', function($payload){
  $filterLoad = Controller::filterPayload($payload);
  if(empty($filterLoad['sectionId']) || 
     empty($filterLoad['colorGroupId']) ||
     empty($filterLoad['itemOrder'])) {
    return response("failure", "No __Id specified");
  }
}, TRUE);

$section->addAction('updateColorSwatch', function($payload){
  $filterLoad = Controller::filterPayload($payload);
  if(empty($filterLoad['sectionId']) || 
     empty($filterLoad['colorSwatchId']) ||
     empty($filterLoad['itemOrder'])) {
    return response("failure", "No __Id specified");
  }
}, TRUE);

/**
 * Section Item Delete Actions
 */



$section->addAction('deleteHeading', function($payload){
  $filterLoad = Controller::filterPayload($payload);
  if(empty($filterLoad['sectionId']) || 
     empty($filterLoad['headingId'])) {
    return response("failure", "No __Id specified");
  }
}, TRUE);

$section->addAction('deleteFont', function($payload){
  $filterLoad = Controller::filterPayload($payload);
  if(empty($filterLoad['sectionId']) || 
     empty($filterLoad['fontId'])) {
    return response("failure", "No __Id specified");
  }
}, TRUE);

$section->addAction('deleteImage', function($payload){
  $filterLoad = Controller::filterPayload($payload);
  if(empty($filterLoad['sectionId']) || 
     empty($filterLoad['imageId'])) {
    return response("failure", "No __Id specified");
  }
}, TRUE);

$section->addAction('deleteColorPallet', function($payload){
  $filterLoad = Controller::filterPayload($payload);
  if(empty($filterLoad['sectionId']) || 
     empty($filterLoad['colorPalletId'])) {
    return response("failure", "No __Id specified");
  }
}, TRUE);

$section->addAction('deleteColorGroup', function($payload){
  $filterLoad = Controller::filterPayload($payload);
  if(empty($filterLoad['sectionId']) || 
     empty($filterLoad['colorGroupId'])) {
    return response("failure", "No __Id specified");
  }
}, TRUE);

$section->addAction('deleteColorSwatch', function($payload){
  $filterLoad = Controller::filterPayload($payload);
  if(empty($filterLoad['sectionId']) || 
     empty($filterLoad['colorSwatchId'])) {
    return response("failure", "No __Id specified");
  }
}, TRUE);

/**
 * Section Item Get by Id Actions
 */



$section->addAction('getHeadingById', function($payload){
  $filterLoad = Controller::filterPayload($payload);
  if(empty($filterLoad['headingId'])){
    return response("failure", "No __Id specified");
  }
  $sectionItem = get_exam_by_id($filterLoad['headingId']);
}, TRUE);

$section->addAction('getFontById', function($payload){
  $filterLoad = Controller::filterPayload($payload);
  if(empty($filterLoad['fontId'])){
    return response("failure", "No __Id specified");
  }
  $sectionItem = get_exam_by_id($filterLoad['fontId']);
}, TRUE);

$section->addAction('getImageById', function($payload){
  $filterLoad = Controller::filterPayload($payload);
  if(empty($filterLoad['imageId'])){
    return response("failure", "No __Id specified");
  }
  $sectionItem = get_exam_by_id($filterLoad['imageId']);
}, TRUE);

$section->addAction('getColorPalletById', function($payload){
  $filterLoad = Controller::filterPayload($payload);
  if(empty($filterLoad['colorPalletId'])){
    return response("failure", "No __Id specified");
  }
  $sectionItem = get_exam_by_id($filterLoad['colorPalletId']);
}, TRUE);

$section->addAction('getColorGroupById', function($payload){
  $filterLoad = Controller::filterPayload($payload);
  if(empty($filterLoad['colorGroupId'])){
    return response("failure", "No __Id specified");
  }
  $sectionItem = get_exam_by_id($filterLoad['colorGroupId']);
}, TRUE);

$section->addAction('getColorSwatchById', function($payload){
  $filterLoad = Controller::filterPayload($payload);
  if(empty($filterLoad['colorSwatchId'])){
    return response("failure", "No __Id specified");
  }
  $sectionItem = get_exam_by_id($filterLoad['colorSwatchId']);
}, TRUE);