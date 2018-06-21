<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/include.php';

function assetRequest($action, $payload){

  switch ($action) {
    case "createAsset":
      // asset variables
      $asset_dir = '/server_assets';
      $asset_dir_path = $_SERVER['DOCUMENT_ROOT'] . $asset_dir;

      // collect needed inputs
      $assetName = $_FILES['fileUpload']['name'];
      $assetPath = $asset_dir . '/' . $assetName;
      $assetType = getAssetType($assetName);
      $assetSize = $_FILES['fileUpload']['size'];
      $assetStatus = filter_input(INPUT_POST, 'assetStatus', FILTER_SANITIZE_STRING);
      $userId = filter_input(INPUT_POST, 'userId', FILTER_SANITIZE_NUMBER_INT);

      if(isset($assetName)) {

        // sends error if asset file is missing
        if(empty($assetName)) {
          return postResp("failure","Coudn't find file. asset_controller.php line 20");
        }

        // sends error if file is an unsupported file type
        if(!fileTypeCheck($assetName) || !$assetType) {
          return postResp("failure", "The uploaded file is an inncorrect file type.");
        }

        $source = $_FILES['fileUpload']['tmp_name'];

        // sends error if no temporary file name exists
        if($source =="") {
          return postResp("failure", "Image tmp_name issue. Please contact your web administrator.");
        }

        // downlaod file to directory on server
        // Idealy it would be good to create a directory for each 
        // user instead of downloading every asset to the main folder
        // just more to improve on in the future
        $target = $asset_dir_path . '/' . $assetName;
        $check = move_uploaded_file($source, $target);

        // Set up payload to create asset row in db
        $payload = ["assetPath" => $assetPath, 
                    "assetName" => $assetName, 
                    "assetType" => $assetType, 
                    "assetStatus" => $assetStatus,
                    "userId" => $userId];

        // create the asset
        $result = create_asset($payload);

        // File successfully uploaded
        if(count($result) == 1) {
          return postResp("success", $assetName . " was uploaded successfully");
        } else {
          return postResp("failure", $assetName . " was not uploaded successfully. Please contact your website administrator or try again.");
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