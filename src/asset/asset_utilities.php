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