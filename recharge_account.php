<?php

    session_start();

    // Include the database connection file from absolute path
    include($_SERVER['DOCUMENT_ROOT'] . '/kfet/lib/connect.php');

    // Check if the user is connected and has the authorisation level
    if(!isset($_SESSION['logged_in'], $_SESSION['auth_level']) || $_SESSION['auth_level'] == 0) {
        // Redirect to the home page
        header('Location: index.php');
    }

?>

<!DOCTYPE html>
<html>
<head>
    <?php include 'templates/head.php'; ?>

    <title>Kfet - Recharger un compte</title>
</head>
<body>

    <?php include 'templates/nav.php'; ?>

    <div class="margin-top">

        <form method="post" autocomplete="off" action="lib/recharge_account.php" class="standard-form">
            <h1>Recharger un compte</h1>

            <div class="form-group">
                <label for="username">Nom complet</label>
                <input type="text" id="username" name="username" list="usernames" class="form-control" required>
            </div>

            <datalist id="usernames">
                <?php
                    // Connect to the database
                    $connection = connectToDatabase();
                    if($connection == FALSE) {
                        $databaseError = TRUE;
                        $databaseErrorMessage = $connection->error;
                    }

                    if($result = $connection->query('SELECT username FROM users')) {
                        while($row = $result->fetch_array()) {
                            echo '<option>' . htmlspecialchars($row['username']) . '</option>';
                        }
                    } else {
                        $databaseError = TRUE;
                        $databaseErrorMessage = $connection->error;
                    }

                    $connection->close();
                ?>
            </datalist>

            <div class="form-group">
                <label for="amount">Montant</label>
                <input type="number" name="amount" id="amount" class="form-control" required placeholder="5€">
            </div>

           <div class="text-center">
                <input type="submit" value="Ajouter" id="btn-validate-lg">
            </div>
        </form>
    </div>
    
    <script src="js/status_message"></script>
    <script type="text/javascript">
         addStatusMessage('update_amount', {
            'success' : 'Le montant a bien été mis à jour !',
            'error' : 'Il y a eu un problème lors de l\'ajout ...'
        })
    </script>
</body>
</html>