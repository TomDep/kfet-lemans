<?php
    session_start();

    require_once('../redirect.php');
    auth_level(2);

    // Error
    $errorMessage = '';
    $databaseError = false;
    $emptyValueError = false;
    $fileError = false;

    // Success
    $successMessage = '';

    require_once('../connect.php');
    require_once('../util.php');

    // Connect to the database
    if(!$mysqli = connectToDatabase()) {
        $databaseError = true;
        $errorMessage = 'Unable to connect to the database';
    }

    // Update a value
    if(isset($_POST['name'], $_POST['pk'])) {
        
        // Just because there is a checkbox that can be edited
        if($_POST['name'] == 'bdlc_member') $value = (isset($_POST['value'])) ? '1' : '0';
        else $value = $_POST['value'];

        if(update($mysqli, 'users', array(array('key' => $_POST['name'], 'value' => $value)), $_POST['pk'])) {
            $successMessage = 'Successfully updated the product with id = ' . $_POST['pk'];
        } else {
            $databaseError = true;
            $errorMessage = 'Failed to update the table "users": ' . $mysqli->error;
        }
    }

    // Send results
    if($databaseError || $emptyValueError || $fileError) {
        // Send an error message if any error
        echo '{"msg": "'. $errorMessage .'"}';
        header('HTTP/1.0 400 Error', true, 400);
    } else {
        // You must send a message to call the success event
        echo '{"success": true}';
        header('HTTP/1.0 200 OK', true, 200);
    }

?>