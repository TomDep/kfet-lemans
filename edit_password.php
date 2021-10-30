<?php
	session_start();

	require_once('lib/redirect.php');
	auth_level(0);
	timeout();

	require_once('lib/connect.php');

	// Redirect if the user isn't connected
	if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] != TRUE) {
		header('Location: login.php');
	} else {

		// Process data from the form
		$invalidPassword = FALSE;
		$error = FALSE;
		$emptyFields = FALSE;
		if((empty($_POST['new_password']) || empty($_POST['password'])) && isset($_POST['submit'])) {
			$emptyFields = TRUE;
			$error = TRUE;
		}

		if(!isset($_POST['submit'], $_POST['password'], $_POST['new_password'])) {
			$error = TRUE;
		}

		if(!$error) {
			// Connect to the database
			$connection = connectToDatabase();
			if($connection == FALSE) {
				header('Location: ?modify_password_status=database_error');
			}

			// Check if the given password matches the one saved
			$req = 'SELECT password FROM users WHERE id = ?';
			if ($stmt = $connection->prepare($req)) {

				$stmt->bind_param('i', $_SESSION['id']);
				$stmt->execute();
				$stmt->store_result();

				if ($stmt->num_rows > 0) {
					$stmt->bind_result($password);
					$stmt->fetch();
					// We verify the password.
					if (password_verify($_POST['password'], $password)) {
						// Verification success! Now we update the password
						$password_hashed = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
						
						$req = 'UPDATE users SET password = ? WHERE id = ?';
						if($stmt = $connection->prepare($req)) {
							$stmt->bind_param('si', $password_hashed, $_SESSION['id']);
							$stmt->execute();
							
							// Redirect to index.php
							header('Location: ?modify_password_status=success');
						}
					} else {
						// Incorrect password
						$invalidPassword = TRUE;
					}
				}
			}
		}
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<?php include "templates/head.php"; ?>
		<title>Kfet - Editer son mot de passe</title>
	</head>

	<body>		
		<?php include "templates/nav.php";?>

		<div class="margin-top">
			<form action="edit_password.php" method="post" autocomplete="off" class="standard-form">		
				<h1>Changement de mot de passe</h1>
				<div class="form-group">
					<label for="password">Mot de passe actuel</label>
					<input type="password" name="password" id="password" class="form-control input-lg" required>
				</div>
				
				<div class="form-group">
					<label for="new_password">Nouveau mot de passe</label>
					<input type="password" name="new_password" id="new_password" class="form-control input-lg" required>
				</div>
				
				<div class="text-center">
					<input type="submit" name="submit" value="Modifier" id="btn-validate-lg">
				</div>
			</form>
		</div>	
	
	<?php
		// Display an error message if the entered password was wrong
		if($invalidPassword == TRUE) {
			//echo '<p>Le mot de passe entré est invalide</p>';
			header('Location: ?modify_password_status=invalid_password');
		}

		// In case the fields are empty
		if($emptyFields == TRUE) {
			//echo '<p>Vous ne pouvez pas laisser les champs vide</p>';
			header('Location: ?modify_password_status=empty_field');
		}
	?>

	<script src="js/status_message.js"></script>
	<script type="text/javascript">
		addStatusMessage('modify_password', {
			'success' : 'Votre mot de passe a été modifié avec succès !',
			'invalid_password' : 'Le mot de passe entré est invalide.',
			'empty_field' : 'Vous ne pouvez pas entrer de mot de passe vide !',
			'database_error' : 'Erreur lors de la connexion à la base de données'
		})
	</script>
</body>
</html>