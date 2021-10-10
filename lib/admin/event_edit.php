<?php

    // Error
    $errorMessage = '';
    $warningMessage = '';
    $databaseError = false;
    $emptyValueError = false;
    $fileError = false;

    // Success
    $successMessage = '';

    require_once('../connect.php');
    require_once('../file.php');
    require_once('../util.php');

    $filenameToSet = '';

    // Connect to the database
    if(!$mysqli = connectToDatabase()) {
        $databaseError = true;
        $errorMessage = 'Unable to connect to the database';
    }

    // If a file was sent
    if(isset($_FILES['file'])) {
        // Get the last image
        $data = select($mysqli, 'events', array('name', 'image'), $_POST['pk']);
        $filenameToRemove = $data[0]['image'];
        $filenameToSet = $data[0]['name'] . '.' . getFileExtansion($_FILES['file']['name']);

        // Remove it
        try {
            removeFile('../../res/images/events/', $filenameToRemove);
        } catch(Exception $e) {
            $warningMessage = $e->getMessage();
        }
        
        // Save the file to the directory
        if(!saveFile('../../res/images/events/', $_FILES['file'], $filenameToSet)) {
            $fileError = true;
            $errorMessage = 'Unable to move the file';
        } else {
            $successMessage = 'Successfully uploaded the file : ' . $filenameToSet;
        }        

        // Update the table
        update($mysqli, 'events', array(array('key' => 'image', 'value' => $filenameToSet)), $_POST['pk']);
    }

    // Update a value
    else if(isset($_POST['name'], $_POST['pk'], $_POST['value'])) {
        if(update($mysqli, 'events', array(array('key' => $_POST['name'], 'value' => $_POST['value'])), $_POST['pk'])) {
        //if(updateSingleValue($mysqli, 'products', $_POST['name'], $_POST['value'], $_POST['pk'])) {
            $successMessage = 'Successfully updated the product with id = ' . $_POST['pk'];
        } else {
            $databaseError = true;
            $errorMessage = 'Failed to update the table "product" when uploading "' . $_FILES['file']['name'] . '": ' . $mysqli->error;
        }
    }

    // Send results
    if($databaseError || $emptyValueError || $fileError) {
        // Send an error message if any error
        echo '{"errorMsg": "'. $errorMessage .'", "warningMessage" : "'. $warningMessage .'"}';
        header('HTTP/1.0 400 Error', true, 400);
    } else {
        // You must send a message to call the success event
        echo '{"success": true, "name": "'. $filenameToSet .'"}';
        header('HTTP/1.0 200 OK', true, 200);
    }

?>