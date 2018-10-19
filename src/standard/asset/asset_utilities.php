<?php
function fileTypeCheck($imgName) {
    $i = strrpos($imgName, '.');
    $ext = substr($imgName, $i);
    
    switch($ext) {
        case ".jpg":
        case ".JPG":
        case ".JPEG":
        case ".jpeg":
        case ".png":
        case ".PNG":
        case ".gif":
        case ".GIF":
        case ".mp4":
        case ".MP4":
        case ".pdf":
        case ".PDF":
            return True;
            break;
            default;
                return False;
                break;
    }
}

function getAssetType($imgName) {
    $i = strrpos($imgName, '.');
    $ext = substr($imgName, $i);
    
    switch($ext) {
        case ".jpg":
        case ".JPG":
        case ".JPEG":
        case ".jpeg":
        case ".png":
        case ".PNG":
        case ".gif":
        case ".GIF":
            return "img";
        break;

        case ".mp4":
        case ".MP4":
            return "video";
        break;

        case ".pdf":
        case ".PDF":
            return "document";
        break;
        
        default;
            return False;
        break;
    }
}