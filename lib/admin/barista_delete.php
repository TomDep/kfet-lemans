<?php

    $databaseError = false;

    require_once('../connect.php');

    $mysqli = connectToDatabase();

    if(isset($_GET['id']) && !empty($_GET['id'])) {
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