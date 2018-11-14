<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/include.php';

/**
 * Image
 * 
 * Images are component links
 * to assets and are dependent upon
 * either an asset or a url image.
 */

 $image = new Controller('image');

 /**
  * Create Image // passing
  *-------------------------
  *
  * Requires:
  * @var int secitonId
  * @var int itemOrder
  *
  * @var string imageUrl
  * -------OR--------
  * @var int assetId // assetId to be removed only the assetPath of the 
  * asset is required to fill in the image URL
  */

  $image->addAction('createImage', function($payload) {
    $filterLoad = Controller::filterPayload($payload);
                  Controller::required(['sectionId', 'itemOrder', 'imageUrl'], $filterLoad);
    $createImage = create_image($filterLoad);
    if($createImage == 1) {
      $sectionItems = Section::getSectionItems($filterLoad['sectionId']);
      return Response::data($sectionItems, 'section Items retrieved');
    } else {
      return Response::err();
    }
  }, TRUE);

  /**
   * Update Image // untested
   * ------------------------
   * 
   * Requires: 
   * @var int sectionId
   * @var int imageId
   * @var int itemOrder
   * 
   * @var string imageUrl
   */

  $image->addAction('updateImage',
    
    function($payload){

      $filterLoad = Controller::filterPayload($payload);
                    Controller::required(['sectionId', 'imageId'], $filterLoad);
      $updateImage = update_image($filterLoad);
      if($updateImage == 1) {
        $sectionItems = Section::getSectionItems($filterLoad['sectionId']);
        return Response::data($sectionItems, 'section Items retrieved');
      } else {
        return Response::err();
      }
    }, TRUE);

   /**
  * Delete Image // unstested
  *-------------------------
  *
  * Requires:
  * @var int secitonId
  * @var int imageId
  */
  $image->addAction('deleteImage', function($payload) {
    $filterLoad = Controller::filterPayload($payload);
                  Controller::required(['sectionId','imageId'], $filterLoad);
    $deleteImage = delete_image($filterLoad);
    if($deleteImage == 1) {
      $sectionItems = Section::getSectionItems($filterLoad['sectionId']);
      return Response::data($sectionItems, 'section Items retrieved');
    } else {
      return Response::err();
    }
  }, TRUE);