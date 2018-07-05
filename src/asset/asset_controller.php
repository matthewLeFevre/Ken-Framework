<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/include.php';

function assetRequest($action, $payload){
  // What if i check for empty inputs at the start of the controller?
  // if(ckEmpty($payload)) { return ckEmpty($payload)};
  // might i conditionally sanitize every input at the start of the
  // controller as well?
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
          return response("failure","Coudn't find file. asset_controller.php line 20");
        }

        // sends error if file is an unsupported file type
        if(!fileTypeCheck($assetName) || !$assetType) {
          return response("failure", "The uploaded file is an inncorrect file type.");
        }

        $source = $_FILES['fileUpload']['tmp_name'];

        // sends error if no temporary file name exists
        if($source =="") {
          return response("failure", "Image tmp_name issue. Please contact your web administrator.");
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
          return response("success", $assetName . " was uploaded successfully");
        } else {
          return response("failure", $assetName . " was not uploaded successfully. Please contact your website administrator or try again.");
        }
      }

    break;

    case "assignAsset": 
      // I don't know how great it is to reassign filtered value here
      // At least it will be filtered though
      // echo json_encode($payload);
      // break;
      $payload["assetId"] = filter_var($payload["assetId"], FILTER_SANITIZE_NUMBER_INT);
      $payload["assignedTable"] = filter_var($payload["assignedTable"], FILTER_SANITIZE_STRING);
      $payload["assignedId"] = filter_var($payload["assignedId"], FILTER_SANITIZE_NUMBER_INT);

      // send errors if data is missing
      if( empty($payload["assetId"]) || empty($payload["assignedTable"]) || empty($payload["assignedId"])) {
        return response("failure", "Required data has not been supplied. Please try again.");
      }

      $assignAssetStatus = assign_asset($payload);

      if($assignAssetStatus == 1) {
        return response("success", "Asset successfully assigned");
      } else {
        return response("failure", "There was an issue assigning the asset.");
      }
    break;

    case "unAssignAsset":
      $assetData["assetId"]  = filter_var($assetData["assetId"], FILTER_SANITIZE_NUMBER_INT);
      $assetData["assigned"] = filter_var($assetData["assignedId"], FILTER_SANITIZE_NUMBER_INT);
      $assetData["assigned"] = filter_var($assetData["assignedTable"], FILTER_SANITIZE_STRING); 
      if(ckEmpty($payload)) { return ckEmpty($payload);}
      $unassignAssetStatus- unassign_asset($payload);
      if($unassignAssetStatus == 1) {
        return response("success", "Asset was unassigned successfully.");
      } else {
        return response("failure", "There was an issue unassigning the asset.");
      }
    break;

    case "changeAssetStatus":
      $payload["assetId"] = filter_var($payload["assetId"], FILTER_SANITIZE_NUMBER_INT);
      $payload["assetStatus"] = filter_var($payload["assetStatus"], FILTER_SANITIZE_STRING);

      // Check for empty inputs
      if(ckEmpty($payload)) { return ckEmpty($payload);}

      $assetChangeStatus = update_asset_status($payload);

      if($assetChangeStatus === 1) {
        return response("success", "Asset has been updated successfully");
      } else {
        return response("failure", "Asset was not updated successfully.");
      }
    break;

    case "deleteAsset":
      $payload["assetId"] = filter_var($payload["assetId"], FILTER_SANITIZE_NUMBER_INT);
      if(ckEmpty($payload)) { return ckEmpty($payload);}

      // before the asset is deleted it should be unassigned
      // from all of its current assignments.

      $deleteAssetStatus = delete_asset($payload);

      if($deleteAssetStatus === 1) {
        return response("success", "Asset deleted.");
      } else {
        return response("failure", "Asset was not deleted.");
      }
    break;

    default:
      return response("failure", "The specified action has not been defined.");
    break;
  }
}