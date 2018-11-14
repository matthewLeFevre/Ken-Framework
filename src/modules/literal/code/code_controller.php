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
      Response::data($sectionItems, 'section Items retrieved');
    } else {
      Response::err();
    }
  }, TRUE);