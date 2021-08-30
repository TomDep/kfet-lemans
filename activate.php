<?php
	session_start();

	require_once('lib/connect.php');

	// Check if the user is already connected
	if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == TRUE) {
		header('Location: index.php');
	}

	// Possible error messages
	$emptyFieldsError = FALSE;
	$alreadyActivatedError = FALSE;
	$databaseError = FALSE;
	$noUserError = FALSE;

	/* step 0 : the user must give their student number
	 * step 1 : the user must give a password */ 
	$step = 0; 
	
	// step 0
	if(isset($_POST['student_number']) && !isset($_POST['password'])) {

		// Make sure the submetted registerations are not empty
		if(empty($_POST['student_number'])) {
			// One or more values are empty
			$emptyFieldsError = TRUE;
		}

		// Connect to the database
		$connection = connectToDatabase();
		if($connection == FALSE) {
			$databaseError = TRUE;
		}

		// Check if the user account is not already activated
		$req = 'SELECT activated FROM users WHERE student_number = ?';
		if($stmt = $connection->prepare($req)) {
			$stmt->bind_param('i', $_POST['student_number']);
			$stmt->execute();
			$stmt->store_result();

			// Check if there is someone registered with this student number
			if($stmt->num_rows == 0) {
				$noUserError = TRUE;
			} else {
				$stmt->bind_result($activated);
				$stmt->fetch();

				// Check if the account is not already activated
				if($activated == TRUE) {
					$alreadyActivatedError = TRUE;
				} else {
					// Go to the next step
					$step = 1;
				}
			}
		}
	}

	// step 1 : Check if the password and the student number has been given
	if(isset($_POST['student_number'], $_POST['password'])) {

		if(empty($_POST['student_number']) || empty($_POST['password'])) {
			$emptyFieldsError = TRUE;
		} else {

			// Connect to the database
			$connection = connectToDatabase();
			if($connection == FALSE) {
				$databaseError = TRUE;
			} else {

				var_dump($_POST['student_number']);

				// Set the password into the database
				$password_hashed = password_hash($_POST['password'], PASSWORD_DEFAULT);
			
				$req = 'UPDATE users SET password = ?, activated = 1 WHERE student_number = ?';
				if($stmt = $connection->prepare($req)) {
					$stmt->bind_param('si', $password_hashed, $_POST['student_number']);
					$stmt->execute();
					
					// Redirect to the login screen
					header('Location: login.php');
				}
			}
		}
	}

?>

<!DOCTYPE html>
<html>
<head>
	<?php include "templates/head.php"; ?>
	<title>Kfet - Se Connecter</title>
</head>
<body>
	<img src="res/icon.svg" id="biggerLogo">

    <section>
		<?php	
			if($step == 0) {
			// The user gives their student number
		?>

		<form action="activate.php" method="post">

			<h1>Bienvenue à toi, 'tit nouveau! </h1>

			<div class="form-group">
			    <label>Numéro étudiant</label>
			    <input type="text" name="student_number" class="form-control input-lg" placeholder="182355" required>			
			    <a href="login.php">Retour à l'écran de connexion</a>
			</div>
		  
		  	<div class="text-center">
		  		<input type="submit" value="Suivant" id="btn-validate-lg">
		  	</div>
		</form>
		
		<?php
			} else if($step == 1) {
			// The user gives a new password (and it's student number using an hidden input)
		?>

		<form action="activate.php" method="post">
			<h1>C'est presque fini...!</h1>

			<div class="form-group">
			    <label>Choississez un mot de passe</label>
			    <input type="password" name="password" id="password" class="form-control input-lg" placeholder="Shhh! C'est secret" required>
			</div>
		  
		  	<div class="text-center">
		  		<input type="submit" value="Valider" id="btn-validate-lg">
		  	</div>
		</form>
<?php
	}
	
	// Error messages
	if($emptyFieldsError == TRUE) echo '<p>Please fill all the needed fields!</p>';
	if($alreadyActivatedError == TRUE) echo '<p>Votre compte est déjà activé</p>';
	if($noUserError) echo '<p>Il n\'y a pas d\'utilisateur avec ce numéro d\'étudiant</p>';
	if($databaseError) echo '<p>Il y a eu une erreur ...</p>';
?>

</body>
</html>
