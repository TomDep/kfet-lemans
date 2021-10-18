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
        header('Location: ../../administrate_users.php?add_status=error');
        exit();
    }

    if(isset($_POST['student_number'], $_POST['username'], $_POST['auth_level'], $_POST['credit'])) {

        $isMember = (isset($_POST['bdlc_member'])) ? '1' : '0';

        // Check if there isn't already a user with this student number
        if($stmt = $mysqli->prepare('SELECT COUNT(*) AS total FROM users WHERE student_number = ?')) {
            $stmt->bind_param('i', $_POST['student_number']);
            $stmt->execute();
            $stmt->bind_result($total);
            $stmt->fetch();
            if($total > 0) {
                header('Location: ../../administrate_users.php?add_status=user_already_exists');
                exit();
            }

            $stmt->close();
        }



        $req = 'INSERT INTO users (student_number, password, username, bdlc_member, auth_level, credit, activated) 
                VALUES (?, \''. getRandomString(10) .'\', ?, ?, ?, ?, 0)';
        var_dump($req);

        if($stmt = $mysqli->prepare($req)) {
            $stmt->bind_param('issid', $_POST['student_number'], $_POST['username'], $isMember, $_POST['auth_level'], $_POST['credit']);
            $stmt->execute();
            $stmt->close();

            if($_POST['auth_level'] > 0) {
                // Adding a new Barista

                $photoName = $_POST['username'] . '.svg';

                $req = 'INSERT INTO baristas (user_id, class, photo) VALUES 
                ((SELECT DISTINCT id FROM users WHERE student_number = ?), \'Inconnue\', ?)';    
                if($stmt = $mysqli->prepare($req)) {
                    $stmt->bind_param('is', $_POST['student_number'], $photoName);
                    $stmt->execute();
                } else {
                    header('Location: ../../administrate_users.php?add_status=barista_error');
                    exit();
                }

                // Move the bdlc icon to the barista folder
                copy('../../res/icon.svg', '../../res/images/baristas/' . $photoName);
            }
        } else {
            header('Location: ../../administrate_users.php?add_status=error');
            exit();
        }

        header('Location: ../../administrate_users.php?add_status=success');
    }
?>