<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/include.php';

$section = new Controller('section');
/**
 * Section actions
 */

// untested
$section->addAction('createSection', function($payload){

  $filterLoad = Controller::filterPayload($payload);

  if(empty($filterLoad['userId']) ||
    empty($filterLoad['styleGuideId']) ||
    empty($filterLoad['order']) ||
    empty($filterLoad['sectionTitle'])){
      return response("failure", "Not all required data was supplied for that section");
      exit;
  }

  // execute database model action
  $createSection = create_section($filterLoad);

  // check for success or failure
  if($createSection == 1) {
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

// untested - possibly is uneeded
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

//untested
$section->addAction('getSectionAndItemsBySectionId', function($payload){

  $filterLoad = Controller::filterPayload($payload);

  if(empty($filterLoad['sectionId'])){
    return response("failure", "No sectionId was specified.");
    exit;
  }
  $secId = $filterLoad['sectionId'];
  $section              = get_section_by_id($secId);
  $sectionTextBoxs      = get_textBoxs_by_sectionId($secId);
  $sectionFonts         = get_fonts_by_sectionId($secId);
  $sectionColorPallets  = get_colorPallets_by_sectionId($secId);
  $sectionHeadings      = get_Headings_by_sectionId($secId);
  $sectionImages        = get_Images_by_sectionId($secId);
  $sectionItems         = array_merge($sectionTextBoxs, $sectionFonts, $sectionColorPallets, $sectionHeadings, $sectionImages);
  $order                = array();

  foreach ($sectionItems as $key => $row) {
    $order[$key] = $row['order'];
  }
  array_multisort($order, SORT_ASC, $sectionItems);

  $sectionData = array_merge($section, $order);

  return dataResp("success", $sectionData, "Section and all items were retrieved.")
});

/**
 * Section Item Create Actions
 */

$section->addAction('createTextBox', function($payload){
  $filterLoad = Controller::filterPayload($payload);
  if(empty($filterLoad['sectionId']) ||
     empty($filterLoad['order'])){
    return response("failure", "Not all data was supplied for this item.");
  }

  $createItem = create_textBox($filterLoad);
  if($createItem == 1) {
    $section->callAction('getSectionAndItemsBySectionId', $filterLoad['sectionId']);
  } else {
    return response('failure', "section Item was not created successfully");
  }

}, TRUE);

$section->addAction('createHeading', function($payload){
  $filterLoad = Controller::filterPayload($payload);
  if(empty($filterLoad['sectionId']) ||
     empty($filterLoad['order'])){
    return response("failure", "Not all data was supplied for this item.");
  }

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
     empty($filterLoad['order'])){
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
     empty($filterLoad['order'])){
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
     empty($filterLoad['order'])){
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
     empty($filterLoad['order'])){
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
     empty($filterLoad['order'])){
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

$section->addAction('updateTextBox', function($payload){
  $filterLoad = Controller::filterPayload($payload);
  if(empty($filterLoad['sectionId']) ||
    empty($filterLoad['textBoxId']) ||
    empty($filterLoad['order'])){
    return response("failure", "No __Id specified");
  }
}, TRUE);

$section->addAction('updateHeading', function($payload){
  $filterLoad = Controller::filterPayload($payload);
  if(empty($filterLoad['sectionId']) || 
     empty($filterLoad['headingId'])  ||
     empty($filterLoad['order'])) {
    return response("failure", "No __Id specified");
  }
}, TRUE);

$section->addAction('updateFont', function($payload){
  $filterLoad = Controller::filterPayload($payload);
  if(empty($filterLoad['sectionId']) || 
     empty($filterLoad['fontId']) ||
     empty($filterLoad['order'])) {
    return response("failure", "No __Id specified");
  }
}, TRUE);

$section->addAction('updateImage', function($payload){
  $filterLoad = Controller::filterPayload($payload);
  if(empty($filterLoad['sectionId']) || 
     empty($filterLoad['imageId']) ||
     empty($filterLoad['order'])) {
    return response("failure", "No __Id specified");
  }
}, TRUE);

$section->addAction('updateColorPallet', function($payload){
  $filterLoad = Controller::filterPayload($payload);
  if(empty($filterLoad['sectionId']) || 
     empty($filterLoad['colorPalletId']) ||
     empty($filterLoad['order'])) {
    return response("failure", "No __Id specified");
  }
}, TRUE);

$section->addAction('updateColorGroup', function($payload){
  $filterLoad = Controller::filterPayload($payload);
  if(empty($filterLoad['sectionId']) || 
     empty($filterLoad['colorGroupId']) ||
     empty($filterLoad['order'])) {
    return response("failure", "No __Id specified");
  }
}, TRUE);

$section->addAction('updateColorSwatch', function($payload){
  $filterLoad = Controller::filterPayload($payload);
  if(empty($filterLoad['sectionId']) || 
     empty($filterLoad['colorSwatchId']) ||
     empty($filterLoad['order'])) {
    return response("failure", "No __Id specified");
  }
}, TRUE);

/**
 * Section Item Delete Actions
 */

$section->addAction('deleteTextBox', function($payload){
  $filterLoad = Controller::filterPayload($payload);
  if(empty($filterLoad['sectionId']) || 
     empty($filterLoad['textBoxId'])) {
    return response("failure", "No __Id specified");
  }
}, TRUE);

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

$section->addAction('getTextBoxById', function($payload){
  $filterLoad = Controller::filterPayload($payload);
  if(empty($filterLoad['textBoxId'])){
    return response("failure", "No __Id specified");
  }
  $sectionItem = get_exam_by_id($filterLoad['textBoxId']);
}, TRUE);

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