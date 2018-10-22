<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/include.php';

/**
 * StyleGuide
 *  
 *  Style Guides are entities that
 *  contain user generated sections
 *  they dictiate the limits of project
 *  styleing
 */

$styleGuide = new Controller('styleGuide');

/**
 * Create StyleGuide // passing
 * --------------
 * 
 *  Requires:
 *  @var int projectId 
 *  @var string styleGuideStatus
 *  @var string styleGuideTitle
 */

$styleGuide->addAction('createStyleGuide', 

  function($payload){

    $filterLoad = Controller::filterPayload($payload);
                  Controller::required(['projectId', 'styleGuideStatus', 'styleGuideTitle'], $filterLoad);

    $createstyleGuide = create_styleGuide($filterLoad);

    if($createstyleGuide == 1) {
      return Response::data(get_styleGuides_by_projectId($filterLoad['projectId']), "styleGuide was successfully created");
    } else {
      return Response::err("styleGuide died :(");
    }

}, TRUE);

/**
 *  Update StyleGuide // passing
 * --------------
 * 
 *  Requires:
 *  @var int styleGuideId 
 *  @var string styleGuideStatus
 *  @var string styleGuideTitle
 */

$styleGuide->addAction('updateStyleGuide', 
  function($payload){

    $filterLoad = Controller::filterPayload($payload);
                  Controller::required(['styleGuideId', 'styleGuideStatus', 'styleGuideTitle'], $filterLoad);

    $updateStyleGuide = update_styleGuide($filterLoad);

    if($updateStyleGuide == 1) {
      return Response::data(get_styleGuides_by_projectId($filterLoad['projectId']), "styleGuide was successfully updated");
    } else {
      return Response::err("styleGuide died :(");
    }

}, TRUE);

/**
 * Delete StyleGuide // passing
 * --------------
 * 
 *  Requires:
 *  @var int projectId
 *  @var int styleGuideId 
 */

$styleGuide->addAction('deleteStyleGuide', 

  function($payload){

    $filterLoad = Controller::filterPayload($payload);
                  Controller::required(['styleGuideId', 'projectId'], $filterLoad);

    $deleteStyleGuide = delete_styleGuide($filterLoad['styleGuideId']);

    if($deleteStyleGuide == 1) {
      return Response::data(get_styleGuides_by_projectId($filterLoad['projectId']),"styleGuide deleted successfully");
    } else {
      return Response::err("styleGuide was not deleted successfully");
    }

}, TRUE);
  
/**
 * Get StyleGuide By Id // @alert untested
 * --------------
 * 
 *  Requires:
 *  @var int styleGuideId 
 */

$styleGuide->addAction('getStyleGuideById', 

  function($payload){

    $filterLoad = Controller::filterPayload($payload);
                  Controller::required(['styleGuideId'], $filterLoad);

    $data = [
      get_styleGuide_by_id($filterLoad['styleGuideId']),
      get_sections_by_styleGuideId($filterLoad['styleGuideId'])
    ];

    return Response::data($data, "styleGuide Data was retrieved");
});

/**
 * Get Public Style Guide By Id // @alert passing
 * --------------
 * 
 *  Requires:
 *  @var int styleGuideId 
 */

$styleGuide->addAction('getPublicStyleGuideById', function($payload){
  $filterLoad = Controller::filterPayload($payload);
                Controller::required(['styleGuideId'], $payload);

  $data = [
    'styleGuide' => get_public_styleGuide_by_id($filterLoad['styleGuideId']),
    'sections' => get_sections_by_styleGuideId($filterLoad['styleGuideId'])
  ];

  return Response::data($data);
});

/**
 * Get Public Style Guide By Id // @alert passing
 * --------------
 * 
 *  Requires:
 *  @var int projectId 
 */

$styleGuide->addAction('getStyleGuidesByProjectId', 

  function($payload){

    $filterLoad = Controller::filterPayload($payload);
                  Controller::required(['projectId'], $filterLoad);

    $styleGuideData = get_styleGuides_by_projectId($filterLoad['projectId']);

    return Response::data($styleGuideData, "styleGuides were retrieved");
});

/**
 * Get Public Style Guide By Id // @alert passing
 * --------------
 * 
 *  Requires:
 *  @var int projectId 
 */

$styleGuide->addAction('getPublicStyleGuides', 

  function($payload){

    $filterLoad = Controller::filterPayload($payload);

    $styleGuideData = get_public_styleGuides();

    return Response::data($styleGuideData, "styleGuides were retrieved");
});