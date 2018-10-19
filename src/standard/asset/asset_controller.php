<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/include.php';

$asset = new Controller('asset');

// Create Asset -- Passing
$asset->addAction('createAsset', function($payload){

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

  if(empty($assetStatus) || empty($userId)) {
    return Response::err("Asset status was not supplied. Please select published or saved.");
    exit;
  }
  if(empty($userId)) {
    return Response::err("UserId was not supplied.");
    exit;
  }

  if(isset($assetName)) {

    // sends error if asset file is missing
    if(empty($assetName)) {
      return Response::err("Coudn't find file.");
    }

    // sends error if file is an unsupported file type
    if(!fileTypeCheck($assetName) || !$assetType) {
      return Response::err("The uploaded file is an inncorrect file type.");
    }

    $source = $_FILES['fileUpload']['tmp_name'];

    // sends error if no temporary file name exists
    if($source =="") {
      return Response::err("Image tmp_name issue. Please contact your web administrator.");
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
      return Response::success($assetName . " was uploaded successfully");
    } else {
      return Response::err($assetName . " was not uploaded successfully. Please contact your website administrator or try again.");
    }
  }
}, TRUE);

// Assign Asset -- Retest
$asset->addAction('assignAsset', function($payload){

  $filteredPayload = array();
  $filteredPayload["assetId"] = filter_var($payload["assetId"], FILTER_SANITIZE_NUMBER_INT);
  $filteredPayload["assignedTable"] = filter_var($payload["assignedTable"], FILTER_SANITIZE_STRING);
  $filteredPayload["assignedId"] = filter_var($payload["assignedId"], FILTER_SANITIZE_NUMBER_INT);
  
  // send errors if data is missing
  if( empty($filteredPayload["assetId"]) || empty($filteredPayload["assignedTable"]) || empty($filteredPayload["assignedId"])) {
    return Response::err("Required data has not been supplied. Please try again.");
  }

  $assignAssetStatus = assign_asset($filteredPayload);

  if($assignAssetStatus == 1) {
    return Response::success("Asset successfully assigned");
  } else {
    return Response::err("There was an issue assigning the asset.");
  }
}, TRUE);

// untested
// Logic that has not yet been implimented correctly
// should be retrieving data from payload not assetData
$asset->addAction('unAssignAsset', function($payload){

  $filteredPayload = array();
  $filteredPayload["assetId"]  = filter_var($payload["assetId"], FILTER_SANITIZE_NUMBER_INT);
  $filteredPayload["assigned"] = filter_var($payload["assignedId"], FILTER_SANITIZE_NUMBER_INT);
  $filteredPayload["assigned"] = filter_var($payload["assignedTable"], FILTER_SANITIZE_STRING); 
  // Check for empty inputs
  // chkEmpty() should not be used here
  // check empty inputs manually
  if(ckEmpty($filteredPayload)) { return ckEmpty($filteredPayload);}
  $unassignAssetStatus- unassign_asset($filteredPayload);
  if($unassignAssetStatus == 1) {
    return Response::err("success", "Asset was unassigned successfully.");
  } else {
    return Response::err("failure", "There was an issue unassigning the asset.");
  }
}, TRUE);

// retest
$asset->addAction('updateAssetStatus', function($payload){

  $filteredPayload = array();
  $filteredPayload["assetId"] = filter_var($payload["assetId"], FILTER_SANITIZE_NUMBER_INT);
  $filteredPayload["assetStatus"] = filter_var($payload["assetStatus"], FILTER_SANITIZE_STRING);
  $filteredPayload["assetModified"] = date('Y-m-d H:i:s');

  if(empty($filteredPayload['assetId']) || empty($filteredPayload['assetStatus'])) {
    return Response::err("please ensure both assetId and assetStatus have values");
  }

  $assetChangeStatus = update_asset_status($filteredPayload);

  if($assetChangeStatus === 1) {
    return Response::success("Asset has been updated successfully");
  } else {
    return Response::err("Asset was not updated successfully.");
  }
}, TRUE);

// retest/unfinished - needs to delete resource from server as well
$asset->addAction('deleteAsset', function($payload){
  $filteredPayload = array();
  $filteredPayload["assetId"] = filter_var($payload["assetId"], FILTER_SANITIZE_NUMBER_INT);

  if(empty($filteredPayload['assetId'])) {
    return Response::err("please include the assetId in the query.");
  }

  $deleteAssetStatus = delete_asset($filteredPayload['assetId']);

  if($deleteAssetStatus === 1) {
    return Response::success("Asset deleted.");
  } else {
    return Response::err("Asset was not deleted.");
  }
}, TRUE);

// untested - should use token validation
$asset->addAction('getAssetsByUserId', function($payload){
  if(empty($payload["userId"])){
    return Response::err();
  }
  $userId = filter_var($payload['userId'], FILTER_SANITIZE_NUMBER_INT);
  $assets = get_assets_by_userId($userId);
  return Response::data($assets, "All of your assets were retrieved.");
}, TRUE);

// untested
$asset->addAction('getPublishedAssetsByUserId', function($payload){
  if(empty($payload["userId"])){
    return Response::err();
  }
  $userId = filter_var($payload['userId'], FILTER_SANITIZE_NUMBER_INT);
  $assets = get_published_assets_by_userId($userId);
  return Response::data($assets, "All of your published assets were retrieved.");
}, TRUE);

// untested
$asset->addAction('getPublishedAssets', function($payload){
  $assets = get_published_assets();
  return Response::data($assets, "All published assets were retrieved.");
});