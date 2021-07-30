<!DOCTYPE html>
<html>
<head>
    <?php include "templates/head.php"; ?>

    <title>Kfet - Gérer l'équipe</title>
</head>
<body>


<h1>Ajouter un.e barista</h1>

<form method="post" autocomplete="off" action="library/add_barista.php" enctype="multipart/form-data">
    
    <label for="username">Nom de l'utilisateur</label>
    <input type="text" id="username" name="username" list="usernames" required>
    <datalist id="usernames">
<?php
    include($_SERVER['DOCUMENT_ROOT'] . '/kfet/library/connect.php');

    // Connect to the database
    $connection = connectToDatabase();
    if($connection == FALSE) {
        echo '<p>Il y a eu une erreur ...</p>';
        exit();
    }

    if($result = $connection->query('SELECT username FROM users')) {
        while($username = $result->fetch_row()) {
            echo '<option>' . htmlspecialchars($username[0]) . '</option>';
        }
    } else {
        echo 'Error : ' . $connection->error;
    }
?>
    </datalist>

    <label for="class">Classe</label>
    <input type="text" name="class" id="class" required>

    <label for="barista_photo">Photo</label>
    <input type="file" name="barista_photo" id="barista_photo">

    <input type="submit" value="Ajouter">

</form>

</body>
</html>
