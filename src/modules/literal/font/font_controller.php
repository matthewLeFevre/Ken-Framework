<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/include.php';

/**
 * Font
 * 
 * Fonts are items stored into the 
 * database that reflect the fonts 
 * included in a project. 
 */

$font = new Controller('font');

/**
 * Create Font // passing
 * -----------------------
 * 
 * Requires:
 * @var int secitonId
 * @var int itemOrder
 * @var string fontUrl
 * @var string fontFamily
 */

$font->addAction('createFont', function($payload){
  $filterLoad = Controller::filterPayload($payload);
                Controller::required(['sectionId', 'itemOrder', 'fontUrl', 'fontFamily'], $filterLoad);
  $createFont = create_font($filterLoad);
  if($createFont == 1) {
    $sectionItems = Section::getSectionItems($filterLoad['sectionId']);
    Response::data($sectionItems, 'section Items retrieved');
  } else {
    Response::err();
  }
}, TRUE);

/**
 * Update Font // untested
 * ------------------------
 * 
 * Requires:
 * @var int secitonId
 * @var int fontId
 */

$font->addAction('updateFont', function($payload){
  $filterLoad = Controller::filterPayload($payload);
                Controller::required(['sectionId', 'fontId'], $filterLoad);
  $updateFont = update_font($filterLoad);
  if($updateFont == 1) {
    $sectionItems = Section::getSectionItems($filterLoad['sectionId']);
    Response::data($sectionItems, 'section Items retrieved');
  } else {
    Response::err();
  }
}, True);

/**
 * Delete Font // passing
 * 
 * Requires:
 * @var int secitonId
 * @var int fontId
 */

 $font->addAction('deleteFont', function($payload) {

  $filterLoad = Controller::filterPayload($payload);
                Controller::required(['sectionId', 'fontId'], $filterLoad);
  $deleteFont = delete_font($filterLoad);
  if($deleteFont == 1) {
    $sectionItems = Section::getSectionItems($filterLoad['sectionId']);
    Response::data($sectionItems, 'section Items retrieved');
  } else {
    Response::err();
  }
 }, TRUE);