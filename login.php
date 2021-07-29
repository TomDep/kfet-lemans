<?php
	session_start();

	if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == TRUE) {
		header('Location: index.php');
	}
?>

<!DOCTYPE html>
<html>
<head>
	<?php include "head.php"; ?>

	<title>Kfet - Se connecter</title>
</head>
<body>

	<div>
		<img class="biggerLogo" src="res/icon.svg" alt="Logo de la KFET">

		<div class="centeredForm">
			<h1>Connexion</h1>
			<form action="authenticate.php" method="post">
			
				<label for="student_number">Numéro étudiant</label>
				<input type="text" name="student_number" placeholder="182355" id="student_number" required>
				
				<label for="password">Mot de passe</label>
				<input type="password" name="password" placeholder="Mot de passe" id="password" required>
				
				<input type="submit" value="Se connecter">
			</form>

			<a href="activate.php">Première connexion ?</a>
		</div>
	</div>

</body>
</html>