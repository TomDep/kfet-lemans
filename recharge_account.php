<?php
    session_start();

    require_once('lib/redirect.php');
    require_once('lib/connect.php');

    auth_level(1);
?>

<!DOCTYPE html>
<html>
<head>
    <?php include 'templates/head.php'; ?>

    <title>Kfet - Recharger un compte</title>

    <link rel="stylesheet" type="text/css" href="css/administrate.css">
</head>
<body>

    <?php include 'templates/nav.php'; ?>

    <div class="margin-top">

        <form method="post" autocomplete="off" action="lib/recharge_account.php" class="standard-form">
            <h1>Recharger un compte</h1>

            <div class="form-group">
                <label for="username">Nom complet ou numéro d'étudiant.e</label>
                <input type="text" id="username" name="username-or-student-number" list="usernames" class="form-control"
                       placeholder="Tom de Pasquale ou 182355" required>
            </div>

            <datalist id="usernames">
                <?php
                    // Connect to the database
                    $mysqli = connectToDatabase();
                    if($mysqli == FALSE) {
                        $databaseError = TRUE;
                        $databaseErrorMessage = $mysqli->error;
                    }

                    if($result = $mysqli->query('SELECT username FROM users')) {
                        while($row = $result->fetch_array()) {
                            echo '<option>' . htmlspecialchars($row['username']) . '</option>';
                        }
                    } else {
                        $databaseError = TRUE;
                        $databaseErrorMessage = $mysqli->error;
                    }

                    $mysqli->close();
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
    
    <script src="js/status_message.js"></script>
    <script type="text/javascript">
         addStatusMessage('update_amount', {
            'success' : 'Le montant a bien été mis à jour !',
            'error' : 'Il y a eu un problème lors de l\'ajout ...'
        })
    </script>
</body>
</html>