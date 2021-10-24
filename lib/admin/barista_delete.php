<?php

    session_start();

    require_once('../redirect.php');
    auth_level(2);

    $databaseError = false;

    require_once('../connect.php');

    $mysqli = connectToDatabase();

    if(isset($_GET['id']) && !empty($_GET['id'])) {
        // Delete the photo from the files
        $req = 'SELECT photo FROM baristas WHERE id = ' .htmlspecialchars($_GET['id']);
        if($result = $mysqli->query($req)) {
            $photoName = $result->fetch_assoc()['photo'];
            $result->close();

            unlink('../../res/images/baristas/' . $photoName);
        }

        // Change the authorization level to 0
        $req = 'UPDATE users SET auth_level = 0 WHERE id = (SELECT user_id FROM baristas WHERE id = '. htmlspecialchars($_GET['id']) .')';
        if(!$mysqli->query($req)) {
            echo $mysqli->error;
        }

        // Delete from the database
        if($mysqli->query('DELETE FROM baristas WHERE id=' . htmlspecialchars($_GET['id']))) {
            header('Location: ../../administrate_baristas.php?delete_status=success');
        } else {
            $databaseError = true;
            echo $mysqli->error;
        }
    }

    if($databaseError) header('Location: ../../administrate_baristas.php?delete_status=error');

?>