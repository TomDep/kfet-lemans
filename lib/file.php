<?php

// The root directory of the site
$ROOT = $_SERVER['DOCUMENT_ROOT'] . '/kfet/res/';

function saveFile($path, $fileArray, $filename) {
    global $ROOT;

    // Create the full path
    $fullPath = $ROOT . $path . $filename;

    // Move the file to the corresponding directory
    if(!move_uploaded_file($fileArray['tmp_name'], $fullPath)) {
        return false;   // Send an error
    }

    // If everything went OK
    return true;
}

function removeFile($path, $filename) {
    global $ROOT;
    return unlink($ROOT . $path . $filename);
}

function getFileExtansion($filename) {
    return strtolower(pathinfo($filename, PATHINFO_EXTENSION));
}

?>