<!DOCTYPE html>
<html>
<head>
    <?php include "templates/head.php"; ?>

    <title>Kfet - L'équipe</title>
</head>
<body>

<h1>Liste des Barista</h1>

<?php

    // Get all baristas from the database
    require_once('library/connect.php');

    // Connect to the database
    $connection = connectToDatabase();
    if($connection == FALSE) {
        echo '<p>Il y a eu une erreur ...</p>';
        exit();
    }

    if($result = $connection->query('SELECT * FROM baristas')) {
        while ($barista = $result->fetch_row()) {
            var_dump($barista);
        }
    }

?>

</body>
</html>