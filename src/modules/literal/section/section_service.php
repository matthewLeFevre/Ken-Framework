<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/include.php';

class Section {
  public Static function getSectionItems ($secId) {
    $sectionTextBoxes      = get_textBoxes_by_sectionId($secId);
    $sectionFonts         = get_fonts_by_sectionId($secId);
    $sectionColorPallets  = get_colorPallets_by_sectionId($secId);
    $sectionColorPallets = Section::palletFilter($sectionColorPallets);
    // var_dump($sectionColorPallets);
    // exit;
    $sectionHeadings      = get_headings_by_sectionId($secId);
    // $sectionImages        = get_images_by_sectionId($secId);
    // $sectionItems         = array_merge($sectionTextBoxes, $sectionFonts, $sectionColorPallets, $sectionHeadings, $sectionImages);
    $sectionItems         = array_merge($sectionTextBoxes, $sectionHeadings, $sectionColorPallets);

    usort($sectionItems, function ($a, $b) {
      if ($a['itemOrder'] == $b['itemOrder']) return 0;
      return ($a['itemOrder'] < $b['itemOrder']) ? -1 : 1;
    });

    return $sectionItems;
  }

  public static function palletFilter($palletItems) {
    $newItem = ['colorPalletId' => null, 'itemOrder' => null, 'colorSwatches' => []];
    $finishedItems = [];
    foreach($palletItems as $pallet) {
      // echo json_encode($newItem['colorSwatches']);
      if($newItem['colorPalletId'] != $pallet['colorPalletId'] && $newItem['colorPalletId'] != null) {
        array_push($finishedItems, $newItem);
        $newItem = ['colorPalletId' => null, 'itemOrder' => null, 'colorSwatches' => []];
      } else {
        $newItem['colorPalletId'] = $pallet['colorPalletId'];
        $newItem['sectionId'] = $pallet['sectionId'];
        $newItem['itemType'] = $pallet['itemType'];
        $newItem['itemOrder'] = $pallet['itemOrder'];
        array_push($newItem['colorSwatches'], ['colorSwatchTitle' => $pallet['colorSwatchTitle'], 'colorSwatchHex' => $pallet['colorSwatchHex'],'colorSwatchRGB' => $pallet['colorSwatchRGB'], 'colorSwatchVar' => $pallet['colorSwatchVar']]);
      }
    }
    return $finishedItems;
  }
}