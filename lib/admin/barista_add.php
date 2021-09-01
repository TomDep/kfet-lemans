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
    
    if(isset($_POST['student_number'], $_POST['class'], $_FILES['photo'])) {
        
        $result = $mysqli->query('SELECT username, id FROM users WHERE student_number=' . $_POST['student_number']);
        $row = $result->fetch_assoc();
        $user_id = $row['id'];
        $username = $row['username'];

        // Add the image
        saveFile('images/baristas/', $_FILES['photo'], $username);
        $extansion = getFileExtansion($_FILES['photo']['name']);

        if(!insert($mysqli, 'baristas', array(
            array('key' => 'user_id', 'value' => $user_id), 
            array('key' => 'class', 'value' => $_POST['class']), 
            array('key' => 'photo', 'value' => $username . '.' . $extansion)
        ))) {
            $databaseError = true;
            $errorMessage = 'Unable to insert the product';
        }    
    }

    if($databaseError || $emptyValueError || $fileError) {
        header('Location: ../../administrate_baristas.php?add_status=error');
    } else {
        header('Location: ../../administrate_baristas.php?add_status=success');
    }
?>