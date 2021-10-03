<?php

    // Errors
    $errorMessage = '';
    $databaseError = false;
    $emptyValueError = false;
    $fileError = false;
    
    // Include lib files
    require_once('../connect.php');
    require_once('../util.php');
    require_once('../file.php');

    // Connect to the database
    if(!$mysqli = connectToDatabase()) {
        $databaseError = true;
        $errorMessage = 'Unable to connect to the database';
    }

    var_dump($_POST);
    
    if(isset($_POST['name'], $_FILES['image'])) {
            
        // Add the image
        saveFile('images/events/', $_FILES['image'], $_POST['name']);
        $extansion = getFileExtansion($_FILES['image']['name']);

        $imgName =  $_POST['name'] . '.' . $extansion;
        $query = 'INSERT INTO events (name, image) VALUES (?, ?)';
        if($stmt = $mysqli->prepare($query)) {  
            $stmt->bind_param('ss', $_POST['name'], $imgName);
            $stmt->execute();
        } else {
            $databaseError = true;
            $errorMessage = 'Unable to insert the product';
        }
    }

    if($databaseError || $emptyValueError || $fileError) {
        echo '<p>Error : ' . $errorMessage . '</p>';
        header('Location: ../../administrate_events.php?add_status=error');
    } else {
        header('Location: ../../administrate_events.php?add_status=success');
    }
?>