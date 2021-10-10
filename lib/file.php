<?php

function saveFile($path, $fileArray, $filename) {
    // Create the full path
    $fullPath = $path . $filename;

    // Move the file to the corresponding directory
    if(!move_uploaded_file($fileArray['tmp_name'], $fullPath)) {
        return false;   // Send an error
    }

    // If everything went OK
    return true;
}

function removeFile($path, $filename) {
    return unlink($path . $filename);
}

function getFileExtansion($filename) {
    return strtolower(pathinfo($filename, PATHINFO_EXTENSION));
}

?>