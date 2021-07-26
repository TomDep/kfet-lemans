<?php
	session_start();
?>

<!DOCTYPE html>
<html>
<head>
<?php
	include('head.php');
?>
	<title>Kfet - Administration</title>

	<link rel="stylesheet" type="text/css" href="css/administration.css">	

</head>
<body>
	<header>
		<?php include('administration/administration_header.php'); ?>
	</header>

	<section id="default">
		<h1>Choix de la section</h1>
	</section>

	<section id="produits" class="hidden">
		<?php include('administration/produits.php'); ?>
	</section>

	<section id="formules" class="hidden">
		<?php include('administration/formules.php'); ?>
	</section>

	<section id="usagers" class="hidden">
		<?php include('administration/usagers.php'); ?>
	</section>

	<section id="statistiques" class="hidden">
		<?php include('administration/statistiques.php'); ?>
	</section>

	<script type="text/javascript" src="js/administration_sections.js"></script>
</body>
</html>

