<?php

    session_start();

    require_once('../redirect.php');
    auth_level(2);

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
        
        $query = 'SELECT username, id FROM users WHERE student_number = ?';
        if(!$stmt = $mysqli->prepare($query)) {
            $databaseError = true;
            $errorMessage = 'Unable to get the user informations';
        } else {

            $stmt->bind_param('i', $_POST['student_number']);
            $stmt->execute();
            $stmt->bind_result($username, $user_id);
            $stmt->fetch();
            $stmt->close();

            // Add the image
            saveFile('../../res/images/baristas/', $_FILES['photo'], $username);
            $extansion = getFileExtansion($_FILES['photo']['name']);

            var_dump($_POST['class']);

            $imgName =  $username . '.' . $extansion;
            $query = 'INSERT INTO baristas (user_id, class, photo) VALUES (?, ?, ?)';
            if($stmt = $mysqli->prepare($query)) {  
                $stmt->bind_param('iss', $user_id, $_POST['class'], $imgName);
                $stmt->execute();
            } else {
                $databaseError = true;
                $errorMessage = 'Unable to insert the product';
            }
        }
    }

    if($databaseError || $emptyValueError || $fileError) {
        echo '<p>Error : ' . $errorMessage . '</p>';
        header('Location: ../../administrate_baristas.php?add_status=error');
    } else {
        header('Location: ../../administrate_baristas.php?add_status=success');
    }
?>