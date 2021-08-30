<?php
	session_start();
?>

<!DOCTYPE html>
<html>
<head>
<?php
	include('templates/head.php');
?>
	<title>Kfet - Administration</title>

	<link rel="stylesheet" type="text/css" href="css/administrate.css">	

</head>
<body>
	<?php include "templates/nav.php"; ?>

	<main>
		<h1 class="text-center mb-4">Choix de la section</h1>

		<div class="grid-box">
            <div class="card text-center">
                <div class="card-body">
                    <img class="card-img-top" src="res/icons/ice-cream-outline.svg">
                </div>
                <div class="card-footer">
                    <a href="administrate_products.php" class="btn btn-primary btn-block">Produits</a>
                </div>
            </div>
            <div class="card text-center">
                <div class="card-body">
                    <img class="card-img-top" src="res/icons/people-outline.svg">
                </div>
                <div class="card-footer">
                    <a href="administrate_users.php" class="btn btn-primary btn-block">Utilisateurices</a>
                </div>
            </div>
            <div class="card text-center">
                <div class="card-body">
                    <img class="card-img-top" src="res/icons/person-add-outline.svg">
                </div>
                <div class="card-footer">
                    <a href="administrate_baristas.php" class="btn btn-primary btn-block">Baristas</a>
                </div>
            </div>
            <div class="card text-center">
                <div class="card-body">
                    <img class="card-img-top" src="res/icons/bag-handle-outline.svg">
                </div>
                <div class="card-footer">
                    <a href="administrate_formules.php" class="btn btn-primary btn-block">Formules</a>
                </div>
            </div>
            <div class="card text-center">
                <div class="card-body">
                    <img class="card-img-top" src="res/icons/list-outline.svg">
                </div>
                <div class="card-footer">
                    <a href="administrate_commands.php" class="btn btn-primary btn-block">Commandes</a>
                </div>
            </div>
            <div class="card text-center">
                <div class="card-body">
                    <img class="card-img-top" src="res/icons/newspaper-outline.svg">
                </div>
                <div class="card-footer">
                    <a href="#" class="btn btn-primary btn-block">Événements</a>
                </div>
            </div>
            <div class="card text-center">
                <div class="card-body">
                    <img class="card-img-top" src="res/icons/bar-chart-outline.svg">
                </div>
                <div class="card-footer">
                    <a href="#" class="btn btn-primary btn-block">Statistiques</a>
                </div>
            </div>
            <div class="card text-center">
                <div class="card-body">
                    <img class="card-img-top" src="res/icons/qr-code-outline.svg">
                </div>
                <div class="card-footer">
                    <a href="#" class="btn btn-primary btn-block">Lydia Pro</a>
                </div>
            </div>
	    </div>
	</main>
</body>
</html>

