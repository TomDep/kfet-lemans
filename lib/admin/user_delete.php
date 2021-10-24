<?php
    session_start();

    require_once('../redirect.php');
    auth_level(2);
    
    $databaseError = false;

    require_once('../connect.php');

    $mysqli = connectToDatabase();

    if(isset($_GET['id']) && !empty($_GET['id'])) {
        // Delete from the database
        if($mysqli->query('DELETE FROM users WHERE id=' . htmlspecialchars($_GET['id']))) {
            header('Location: ../../administrate_users.php?delete_status=success');
        } else {
            $databaseError = true;
            echo $mysqli->error;
        }

        // Remove the img from the barista folder
        $req = 'SELECT photo FROM baristas WHERE user_id = ' .htmlspecialchars($_GET['id']);
        if($result = $mysqli->query($req)) {
            $photoName = $resul->fetch_assoc()['photo'];
            $result->close();

            unlink('../../res/images/baristas/' . $photoName);
        }

        // Delete the barista if it exists
        $mysqli->query('DELETE FROM baristas WHERE user_id = ' . htmlspecialchars($_GET['id']));

    }

    if($databaseError) header('Location: ../../administrate_users.php?delete_status=error');

?>