<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/include.php';

$colorPallet = new Controller('colorPallet');

$colorPallet->addAction('createColorPallet', function($payload) {
  $filterLoad = Controller::filterPayload($payload);
  Controller::required(['sectionId', 'itemOrder'], $filterLoad);

  $createPallet = create_colorPallet($filterLoad);
  if($createPallet = 1) {
    $sectionItems = Section::getSectionItems($filterLoad['sectionId']);
    return Response::data($sectionItems, 'section Items retrieved');
  } else {
    Response::err();
  }
}, TRUE);

$colorPallet->addAction('deleteColorPallet', function ($payload) {
  $filterLoad = Controller::filterPayload($payload);
                Controller::required(['sectionId', 'colorPalletId'], $filterLoad);
  $deletePallet = delete_colorPallet($filterLoad);
  if($deletePallet == 1) {
    $sectionItems = Section::getSectionItems($filterLoad['sectionId']);
    return Response::data($sectionItems, 'section Items retrieved');
  } else {
    Response::err();
  }
}, TRUE);

// $colorPallet->addAction('updateColorPallet', function ($payload) {
//   $filterLoad = Controller::filterPayload($payload);
//                 Controller::required(['sectionId', 'colorPalletId'], $filterLoad);
//   $updatePallet = update_colorPallet($filterLoad);
//   if($updatePallet == 1) {
//     $sectionItems = Section::getSectionItems($filterLoad['sectionId']);
//     return Response::data($sectionItems, 'section Items retrieved');
//   } else {
//     return Response::err();
//   }
// }, TRUE);

$colorPallet->addAction('getColorPalletById', function ($payload) {
  
}, TRUE);

$colorPallet->addAction('createColorSwatch', function ($payload) {
  $filterLoad = Controller::filterPayload($payload);
  Controller::required(['colorPalletId', 'itemOrder', 'colorSwatchHex', 'sectionId'], $filterLoad);
  $createSwatch = create_colorSwatch($filterLoad);
  if($createSwatch = 1) {
    $sectionItems = Section::getSectionItems($filterLoad['sectionId']);
    return Response::data($sectionItems, 'section Items retrieved');
  } else {
    Response::err();
  }
}, TRUE);

$colorPallet->addAction('deleteColorSwatch', function($payload) {
  $filterLoad = Controller::filterPayload($payload);
  Controller::required(['colorSwatchId', 'sectionId'], $filterLoad);
  $deleteSwatch = delete_colorSwatch($filterLoad);
  if($deleteSwatch = 1) {
    $sectionItems = Section::getSectionItems($filterLoad['sectionId']);
    return Response::data($sectionItems, 'section Items retrieved');
  } else {
    Response::err();
  }
}, TRUE);

// INSERT INTO `colorswatch`(`colorSwatchHex`, `itemOrder`, `colorSwatchTitle`, `colorPalletId`) VALUES ('#FA9F42', 1, 'neon carrot', 6);
// INSERT INTO `colorswatch`(`colorSwatchHex`, `itemOrder`, `colorSwatchTitle`, `colorPalletId`) VALUES ('#387780', 1, 'ming', 6);
// INSERT INTO `colorswatch`(`colorSwatchHex`, `itemOrder`, `colorSwatchTitle`, `colorPalletId`) VALUES ('#FF5666', 3, 'fiery rose', 6);