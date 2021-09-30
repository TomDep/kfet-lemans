<?php

function auth_level($level) {
    if($level > 0) {
        // The user must be connected
        if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == FALSE) {
            // Redirect to the login page
            header('Location: login.php');
        } else {
            // Check the authorize level
            if($_SESSION['auth_level'] < $level) {
                // Redirecte to the home page
                header('Location: index.php');
            }
        }
    }
}

?>