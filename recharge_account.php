<?php

    session_start();

    // Include the database connection file from absolute path
    include($_SERVER['DOCUMENT_ROOT'] . '/kfet/lib/connect.php');

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

    $operationSuccess = FALSE;

    if(isset($_POST['username'], $_POST['amount'])) {

        if(empty($_POST['username']) || empty($_POST['amount'])) {
            // Raise an empty field error
            $emptyFieldsError = TRUE;
        } else {
            // Connect to the database
            $connection = connectToDatabase();
            if($connection == FALSE) {
                $databaseError = TRUE;
                $databaseErrorMessage = $connection->error;
            } else {

                // Check if the account exists
                $req = 'SELECT id FROM users WHERE username = ?';
                if($stmt = $connection->prepare($req)) {
                    $stmt->bind_param('s', $_POST['username']);
                    $stmt->execute();
                    $stmt->store_result();

                    if($stmt->num_rows == 0) {
                        // No user with this username
                        $noUserError = TRUE;
                    } else {
                        $stmt->bind_result($id);
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

        <form method="post" autocomplete="off" action="#" class="standard-form">
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
                <input type="number" name="amount" id="amount" class="form-control" required placeholder="10 ou 5.5">
            </div>

           <div class="text-center">
                <input type="submit" value="Ajouter" id="btn-validate-lg">
            </div>
        </form>
    </div>
    

<?php
    if($emptyFieldsError) echo '<p>Vous devez remplir les deux champs.</p>';
    if($databaseError) echo '<p>Erreur de la base de donnée : ' . $databaseErrorMessage . '</p>';
    if($noUserError) echo '<p>Le nom entré ne correspond à aucun.e utilisateurice.</p>';
    if($operationSuccess) echo '<p>Le montant à bien été mis à jour !</p>';
?>

</body>
</html>