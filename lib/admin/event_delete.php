<?php
session_start();

require_once('../redirect.php');
auth_level(2);

$databaseError = false;

require_once('../connect.php');
require_once('../util.php');
require_once('../file.php');

$mysqli = connectToDatabase();

if(isset($_GET['id']) && !empty($_GET['id'])) {

    // Get the name of the image
    $data = select($mysqli, 'events', array('image'), $_GET['id']);
    $filenameToRemove = $data[0]['image'] . '.' . getFileExtansion($_FILES['file']['name']);

    // Remove the image
    removeFile('images/products/', $filenameToRemove);

    // Delete from the database
    if($mysqli->query('DELETE FROM events WHERE id=' . htmlspecialchars($_GET['id']))) {
        header('Location: ../../administrate_events.php?delete_status=success');
    } else {
        $databaseError = true;
        echo $mysqli->error;
    }
}

if($databaseError) header('Location: ../../administrate_events.php?delete_status=error');