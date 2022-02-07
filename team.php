<?php
    
    session_start();
    require_once("lib/redirect.php");
    auth_level(0);

?>

<!DOCTYPE html>
<html>
<head>    
    <title>Kfet - L'équipe</title>

    <?php include "templates/head.php"; ?>
    <link rel="stylesheet" type="text/css" href="css/team.css" />
</head>
<body>
    <?php include "templates/nav.php";?>

    <div id="header-team">
        <h1>Présentation de l'équipe 2021-2022</h1>
        <p>L'équipe est là pour vous accueillir de nouveau et repartir pour une nouvelle année déchainée à vos côtés! <br><br>
        N'oubliez pas que l'équipe vous accompagne et gère également les recharges de vos comptes! <br></p>
    </div>
       
    <div id="under">

<?php

    // Include the database connection file
    require_once('lib/connect.php');

    // Connect to the database
    $mysqli = connectToDatabase();
    if($mysqli == FALSE) {
        echo '<p>Il y a eu une erreur ...</p>';
        exit();
    }

    $req = 'SELECT b.class, b.photo, u.username FROM baristas b INNER JOIN users u ON b.user_id = u.id';
    if($result = $mysqli->query($req)) {
        while($barista = $result->fetch_assoc()) {
?>
        <div class="presentation-card-lg">
                <img class="card-picture" src="res/images/baristas/<?php echo(htmlspecialchars($barista["photo"])); ?>"
                onerror="this.src = 'res/icon.svg';">

                <div class="content">
                    <h4 class="card-name"><?php echo(htmlspecialchars($barista["username"])); ?></h4>
                    <h4 class="card-subtitles"><?php echo(htmlspecialchars($barista["class"])); ?></h4>
                </div>
        </div>
<?php   }
    }
 ?>
    </div>
</body>
</html>