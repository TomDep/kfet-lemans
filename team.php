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

    $req = 'SELECT * FROM users INNER JOIN baristas WHERE users.id = baristas.user_id';
    if($result = $connection->query($req)) {
        while($barista = $result->fetch_array()) {
?>
    <div>
        <p><?php echo htmlspecialchars($barista['username']); ?></p>
        <p> Classe : <?php echo htmlspecialchars($barista['class']); ?></p>
        <img src="res/images/baristas/<?php echo htmlspecialchars($barista['photo']); ?>">
    <div>
<?php
        }
    }

    $connection->close();
?>

</body>
</html>