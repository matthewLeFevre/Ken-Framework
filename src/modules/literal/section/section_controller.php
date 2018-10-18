<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/include.php';

/**
 * Section
 *  
 *  Sections are entities that
 *  contain user generated items
 *  that sum up the markup of pages
 *  for styleguides
 */

$section = new Controller('section');

/**
 * Create Section // passing
 * --------------
 * 
 *  Requires:
 *  @var int styleGuideId 
 *  @var int itemOrder
 *  @var string sectionTitle
 * 
 * Notes:
 *  @todo add a section description to the model
 */

$section->addAction('createSection', 

  function($payload){

    $filterLoad = Controller::filterPayload($payload);
                  Controller::required(['styleGuideId', 'itemOrder', 'sectionTitle'], $filterLoad);

    $createSection = create_section($filterLoad);

    if($createSection == 1) {
      return Response::data(get_sections_by_styleGuideId($filterLoad['styleGuideId']), "section was successfully created");
    } else {
      return Response::err("section died :( on querey to create");
    }

}, TRUE);

/**
 * Update Section // passing
 * --------------
 * 
 *  Requires:
 *  @var int userId 
 *  @var int itemOrder
 *  @var int sectionId
 *  @var string sectionTitle
 */

$section->addAction('updateSection', 

  function($payload){

    $filterLoad = Controller::filterPayload($payload);
                  Controller::required(['userId', 'itemOrder', 'sectionId', 'sectionTitle'], $filterLoad);
    
    $updateSection = update_section($filterLoad);

    if($updateSection == 1) {
      return Response::data(get_section_by_Id($filterLoad['sectionId']), "section was successfully updated");
    } else {
      return Response::err("section died :( when queryed to update.");
    }

}, TRUE);

/**
 * Update Section And Items // unfinished
 * --------------
 * 
 *  Notes:
 *  @todo finish development of this feature $section->addAction('updateSectionAndItems', function($payload){}, TRUE);
 */

/**
 * Delete Section // passing
 * --------------
 * 
 *  Requires:
 *  @var int sectionId
 */

$section->addAction('deleteSection', 

  function($payload){
    
    $filterLoad = Controller::filterPayload($payload);
                  Controller::required(['sectionId'], $filterLoad);

    $deletesection = delete_section($filterLoad['sectionId']);

    if($deletesection == 1) {
      return Response::data(get_sections_by_styleGuideId($filterLoad['styleGuideId']));
    } else {
      return Response::err("Project was not deleted successfully");
    }

}, TRUE);
  
/**
 * Get Section By Id // passing
 * --------------
 * 
 *  Requires:
 *  @var int sectionId
 */

$section->addAction('getSectionById', 

  function($payload){

    $filterLoad = Controller::filterPayload($payload);
                  Controller::required(['sectionId'], $filterLoad);
    
    $sectionData = get_section_by_id($filterLoad['sectionId']);

    return Response::data($sectionData, "section Data was retrieved");

});

/**
 * Get Section By User Id // passing
 * --------------
 * 
 *  Requires:
 *  @var int userId
 */
$section->addAction('getSectionsByUserId', 

  function($payload){

    $filterLoad = Controller::filterPayload($payload);
                  Controller::required(['userId'], $filterLoad);

    $sectionData = get_sections_by_userId($filterLoad['userId']);

    return Response::data($sectionData, "sections were retrieved");

}, TRUE);

/**
 * Get Section By StyleGuide Id // passing
 * --------------
 * 
 *  Requires:
 *  @var int styleGuideId
 */

$section->addAction('getSectionsByStyleGuideId', 

  function($payload){

    $filterLoad = Controller::filterPayload($payload);
                  Controller::required(['styleGuideId'], $filterLoad);

    $sectionData = get_sections_by_styleGuideId($filterLoad['styleGuideId']);
                  array_multisort(array_column($sectionData, 'itemOrder'), SORT_ASC, SORT_NUMERIC, $sectionData);

    return Response::data($sectionData, "sections were retrieved");

});

/**
 * Get Section and Items by Section Id // passing
 * --------------
 * 
 *  Requires:
 *  @var int sectionId
 */

$section->addAction('getSectionAndItemsBySectionId', 

  function($payload){

    $filterLoad = Controller::filterPayload($payload);
                  Controller::required(['sectionId'], $filterLoad);
    $sectionItems = Section::getSectionItems($filterLoad['sectionId']);
    $section = get_section_by_id($filterLoad['sectionId']);
    $sectionData = array("section" => $section, "items" => $sectionItems);

    return Response::data($sectionData, "Section and all items were retrieved.");

});