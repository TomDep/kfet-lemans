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
	<?php include "templates/head.php"; ?>

	<title>Kfet - Mon Compte</title>
</head>
<body>

<?php
	// Informations about the user
	echo '<h2>' . htmlspecialchars($_SESSION['username']) . '</h2>';
	echo '<p>Solde : ' . htmlspecialchars($_SESSION['credit']) . ' €</p>';

	echo '<p>Status BDLC : ';
	echo ($_SESSION['bdlc_member']) ? 'Adhérent.e' : 'Non adhérent.e';
	echo '</p>';

	echo '<p>Status du compte : ';

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

<a href="edit_password.php">Modifier mon mot de passe</a>

<p>Pour ajouter de l'argent à ton solde, demande à un.e barista !</p>

</body>
</html>