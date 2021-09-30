<?php
	session_start();

	// Redirect if the user isn't connected
	if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] != TRUE) {
		header('Location: login.php');
	}
?>

<!DOCTYPE html>
<html>
<head>	
	<title>Kfet - Mon Compte</title>
	
	<?php include "templates/head.php"; ?>
	<link rel="stylesheet" type="text/css" href="css/profile.css" />
</head>
<body>
	<?php include "templates/nav.php";?>

	<div class="profile-container">
		<div class="profile-section">
			<?php
			// User's informations
			echo '<h2>' . htmlspecialchars($_SESSION['username']) . '</h2>';

			echo '<p><b>Solde actuel</b>: ' . htmlspecialchars($_SESSION['credit']) . '€</p>';

			echo '<p><b>Status BDLC</b>: ';
			echo ($_SESSION['bdlc_member']) ? 'Adhérent.e' : 'Non adhérent.e';
			echo '</p>';

			echo '<p><b>Status du compte</b>: ';

			switch ($_SESSION['auth_level']) {
				case 0:
					echo 'Ensimien.ne';
					break;
				case 1:
					echo 'Barista';
					break;
				case 2:
					echo 'Administrateurice';
					break;
			}
			echo '</p>';
			?>

			<br><p>Pssst! Pour ajouter de l'argent à ton solde... <br> Demande directement aux baristas! ;)</p><br>
		</div>

		<div class="profile-settings">
			<h6 class="text-center" style="border-bottom:1px solid black">Paramètres</h6>
			<p class="text-center"><a href="edit_password.php">Modifier mon mot de passe</a></p>
			<!--<p class="text-center"><a href="edit_password.php">Ajouter de l'argent au compte</a></p>-->
		</div>

	</div>
	
</body>
</html>