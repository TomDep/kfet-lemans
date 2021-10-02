<?php

function auth_level($level) {
    if($level >= 0) {

        timeout();  // Add a timeout

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

function timeout($amount = 180) {
    if (isset($_SESSION['LAST_REQUEST_TIME'])) {
        if (time() - $_SESSION['LAST_REQUEST_TIME'] > $amount) {
            // session timed out, last request is longer than the timeout amount
            header('Location: login.php');
        }
    }

    $_SESSION['LAST_REQUEST_TIME'] = time();
}

?>