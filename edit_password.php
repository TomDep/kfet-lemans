<?php
	session_start();

	require_once('library/connect.php');

	// Redirect if the user isn't connected
	if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] != TRUE) {
		header('Location: login.php');
	}

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
			exit();
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
						header('Location: index.php');
					}
				} else {
					// Incorrect password
					$invalidPassword = TRUE;
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
		<h2>Changement de mot de passe</h2>

		<form action="edit_password.php" method="post" autocomplete="off">
			
			<label for="password">Mot de passe actuel</label>
			<input type="password" name="password" id="password" required>

			<label for="new_password">Nouveau mot de passe</label>
			<input type="password" name="new_password" id="new_password" required>

			<input type="submit" name="submit" value="Modifier">
		</form>

	<?php
		// Display an error message if the entered password was wrong
		if($invalidPassword == TRUE) {
			echo '<p>Le mot de passe entré est invalide</p>';
		}

		// In case the fields are empty
		if($emptyFields == TRUE) {
			echo '<p>Vous ne pouvez pas laisser les champs vide</p>';
		}
	?>

	</body>
</html>

<body>
		<img src="res/icon.svg" id="biggerLogo">

	    <section>
			<form action="library/authenticate.php" method="post">
				<h1>Bienvenue! </h1>

				<div class="form-group">
				    <label>Numéro étudiant</label>
				    <input type="text" name="student_number" class="form-control input-lg" placeholder="182355" required>
				</div>

				<div class="form-group">
				    <label>Mot de passe</label>
				    <input type="password" name="password" class="form-control" id="password" placeholder="Shhh! C'est secret" required>

				    
				    <div class="float-right">
				    	<a href="edit_password.php">Mot de passe oublié ?</a>
				    </div>
				    <div class="float-left">
				    	<a href="activate.php">Première connexion ?</a>
					</div>							  	
				</div>
			  
			  	<div class="text-center">
			  		<input type="submit" value="Se connecter" class="btn-validate-lg">
			  	</div>
			</form>
		</section>
	</body>