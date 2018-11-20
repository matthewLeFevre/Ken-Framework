<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/include.php';

/**
 * Code
 * 
 * Code allows the user to specify code
 * for html css js or php. It formates 
 * the user defined code in a way to 
 * make it readable.
 */

$code = new Controller('code');

/**
 * Create code // untested
 * -----------------------
 * 
 * Requires:
 * @var int secitonId
 * @var int itemOrder
 * @var string codeLanguage
 */

 $code->addAction('createCode', 
 
  function($payload){

    $filterLoad = Controller::filterPayload($payload);
                  Controller::required(['sectionId', 'itemOrder', 'codeLanguage'], $filterLoad);

    $createCode = create_code($filterLoad);

    if($createCode == 1) {
      $sectionItems = Section::getSectionItems($filterLoad['sectionId']);
      return Response::data($sectionItems, 'section Items retrieved');
    } else {
      return Response::err();
    }
  }, TRUE);

/**
 * Update code // untested
 * -----------------------
 * 
 * Requires:
 * @var int secitonId
 * @var int codeId
 */

 $code->addAction('updateCode', 
 
  function($payload){
    var_dump($payload);
    exit;
    $filterLoad = Controller::filterPayload($payload);
                  Controller::required(['sectionId', 'codeId'], $filterLoad);
    // if($payload["codeMarkup"] != null) {
    //   $filterLoad["codeMarkup"] = Controller::filterHTML($payload["codeMarkup"]);
    // }
    
    $updateCode = update_code($filterLoad);

    if($updateCode == 1) {
      $sectionItems = Section::getSectionItems($filterLoad['sectionId']);
      return Response::data($sectionItems, 'section Items retrieved');
    } else {
      return Response::err();
    }

  }, TRUE);
  
/**
 * Delete code // untested
 * -----------------------
 * 
 * Requires:
 * @var int secitonId
 * @var int codeId
 */

$code->addAction('deleteCode', 
  
  function($payload){
    $filterLoad = Controller::filterPayload($payload);
                  Controller::required(['sectionId', 'codeId'], $filterLoad);
    
    $deleteCode = delete_code($filterLoad);

    if($deleteCode == 1) {
      $sectionItems = Section::getSectionItems($filterLoad['sectionId']);
      return Response::data($sectionItems, 'section Items retrieved');
    } else {
      return Response::err();
    }
    
  }, TRUE);