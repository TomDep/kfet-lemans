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

    if(isset($_POST['student_number'], $_POST['username'], $_POST['auth_level'], $_POST['credit'])) {

        $isMember = (isset($_POST['bdlc_member'])) ? '1' : '0';

        // Check if there isn't already a user with this student number
        if($stmt = $mysqli->prepare('SELECT COUNT(*) as total FROM users WHERE student_number = ?')) {
            $stmt->bind_param('i', $_POST['student_number']);
            $stmt->execute();
            $stmt->bind_result($total);
            $stmt->fetch();
            if($total > 0) {
                header('Location: ../../administrate_users.php?add_status=user_already_exists');
                exit();
            }
        }

        if(!insert($mysqli, 'users', array(
            array('key' => 'student_number', 'value' => $_POST['student_number']),
            array('key' => 'password', 'value' => getRandomString(10)), 
            array('key' => 'username', 'value' => $_POST['username']), 
            array('key' => 'bdlc_member', 'value' => $isMember), 
            array('key' => 'auth_level', 'value' => $_POST['auth_level']),
            array('key' => 'credit', 'value' => $_POST['credit']),
            array('key' => 'activated', 'value' => 0)
        ))) {
            $databaseError = true;
            $errorMessage = 'Unable to insert the user';
        }
    }

    if($databaseError || $emptyValueError || $fileError) {
        header('Location: ../../administrate_users.php?add_status=error');
    } else {
        header('Location: ../../administrate_users.php?add_status=success');
    }
?>