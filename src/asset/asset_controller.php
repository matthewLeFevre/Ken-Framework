<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/include.php';

// asset variables
$asset_dir = '/server_assets';
$asset_dir_path = $_SERVER['DOCUMENT_ROOT'] . $asset_dir;

function assetRequest($action, $payload){
  switch ($action) {
    case "createAsset":
      $assetName = $_FILES['fileUpload']['name'];

      if(isset($assetName)) {

        if(empty($assetName)) {
          return $error = ["status"=>"failure", "message" => "Coudn't find file. asset_controller.php line 20"];
        }

        if(!fileTypeCheck($assetName)) {
          return $error = ["status"=>"failure", "message" => "Incorrect file type. asset_controller.php line 15"];
        }

        $source = $_FILES['fileUpload']['tmp_name'];
        if($source =="") {
          return $error = ["status"=>"failure", "message" => "Image tmp_name issue"];
        }

        $target = $asset_dir_path . '/' . $fileName;

        $check = move_uploaded_file($source, $target);

        $payload["assetPath"] = $asset_dir . '/' . $assetName;

        $result = create_asset($payload);

        if(count($result) == 1) {
          return $success = ["status"=>"success", "message"=> $assetName . "was uploaded successfully"];
        }
      }

    break;
    case "assignAsset": 
    break;
    case "changeAssetStatus":
    break;
    case "deleteAsset":
    break;
  }
}