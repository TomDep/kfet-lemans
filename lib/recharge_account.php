<?php

    session_start();

    require_once('redirect.php');
    auth_level(2);
    
    // Include the database connection file from absolute path
    require_once('connect.php');

    // Check if the user is connected and has the authorisation level
    if(!isset($_SESSION['logged_in'], $_SESSION['auth_level']) || $_SESSION['auth_level'] == 0) {
        // Redirect to the home page
        header('Location: index.php');
    }

    // --- Process form submition ---
    
    // Errors
    $emptyFieldsError = FALSE;
    $databaseError = FALSE;
    $databaseErrorMessage = '';
    $noUserError = FALSE;

    $username = "";

    $operationSuccess = FALSE;

    if(isset($_POST['username-or-student-number'], $_POST['amount'])) {

        if(empty($_POST['username-or-student-number']) || empty($_POST['amount'])) {
            // Raise an empty field error
            $emptyFieldsError = TRUE;
        } else {
            // Connect to the database
            $connection = connectToDatabase();
            if($connection == FALSE) {
                $databaseError = TRUE;
                $databaseErrorMessage = $connection->error;
            } else {

                require_once "util.php";
                $student_number = formatStudentNumber($_POST["username-or-student-number"]);

                // Check if the account exists
                $req = 'SELECT id, username FROM users WHERE username = ? OR student_number = ?';
                if($stmt = $connection->prepare($req)) {
                    $stmt->bind_param('si', $_POST['username-or-student-number'], $student_number);
                    $stmt->execute();
                    $stmt->store_result();

                    if($stmt->num_rows == 0) {
                        // No user with this username
                        $noUserError = TRUE;
                    } else {
                        $stmt->bind_result($id, $username);
                        $stmt->fetch();

                        // Update the account credits
                        $req = 'UPDATE users SET credit = credit + ? WHERE id = ?';
                        $stmt = $connection->prepare($req);
                        $stmt->bind_param('di', $_POST['amount'], $id);
                        if(!$stmt->execute()) {
                            $databaseError = TRUE;
                        } else {
                            $operationSuccess = TRUE;
                        }
                    }

                } else {
                    $databaseError = TRUE;
                }
            }

            if($databaseError) $databaseErrorMessage = $connection->error;
            $connection->close();
        }
    }

    if(($emptyFieldsError || $databaseError || $noUserError) && !empty($username)) {
        header('Location: ../recharge_account.php?update_amount_status=error');
    } else {
        header('Location: ../recharge_account.php?update_amount_status=success&username=' . $username);
    }

?>