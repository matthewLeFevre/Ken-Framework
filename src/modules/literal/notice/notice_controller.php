<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/include.php';

/**
 * Notice
 * 
 * A notice is a message with a very
 * direct command or meaning. Notice's
 * are used to bring awarness to a certain
 * contextual element in the documentation
 * guide or library.
 */

 $notice = new Controller('notice');

/**
 * Create Notice - passing
 * -------------------
 * 
 * Requires:
 * @var int sectionId
 * @var int itemOrder
 */

 $notice->addAction('createNotice', 
 
  function($payload){

      $filterLoad = Controller::filterPayload($payload);
                    Controller::required(['sectionId', 'itemOrder'], $filterLoad);

      $createNotice = create_notice($filterLoad);

      if($createNotice == 1) {
        $sectionItems = Section::getSectionItems($filterLoad['sectionId']);
        return Response::data($sectionItems, 'section Items retrieved');
      } else {
        return Response::err();
      }

  }, TRUE);

/**
 * Update Notice - passing
 * -------------------
 * 
 * Requires:
 * @var int sectionId
 * @var int noticeId
 */

 $notice->addAction('updateNotice', 
 
  function($payload){

    $filterLoad = Controller::filterPayload($payload);
                  Controller::required(['sectionId', 'noticeId'], $filterLoad);

    $updateNotice = update_notice($filterLoad);

    if($updateNotice == 1) {
      $sectionItems = Section::getSectionItems($filterLoad['sectionId']);
      return Response::data($sectionItems, 'section Items retrieved');
    } else {
      return Response::err("update notice threw an error");
    }

  }, TRUE);

/**
 * Delete Notice - passing
 * -------------------
 * 
 * Requires:
 * @var int sectionId
 * @var int noticeId
 */

$notice->addAction('deleteNotice',

  function($payload){

    $filterLoad = Controller::filterPayload($payload);
                  Controller::required(['sectionId', 'noticeId'], $payload);

    $deleteNotice = delete_notice($payload);

    if($deleteNotice == 1) {
      $sectionItems = Section::getSectionItems($filterLoad['sectionId']);
      return Response::data($sectionItems, 'section Items retrieved');
    } else {
      return Response::err();
    }

  }, TRUE);