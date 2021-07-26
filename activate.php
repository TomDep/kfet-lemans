<?php
	session_start();

	require_once('connect.php');

	// Check if the user is already connected
	if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == TRUE) {
		header('Location: index.php');
	}

	// Check if the password and the student number has been given
	if(isset($_POST['student_number'], $_POST['password']) && $_SESSION['id']) {

		if(!(empty($_POST['student_number']) || empty($_POST['password']))) {
			// Connect to the database
			$connection = connect_to_database();
			if($connection == FALSE) {
				exit();
			}

			// Set the password into the database
			$password_hashed = password_hash($_POST['password'], PASSWORD_DEFAULT);
		
			$req = 'UPDATE users SET password = ? WHERE id = ?';
			if($stmt = $connection->prepare($req)) {
				$stmt->bind_param('si', $password_hashed, $_SESSION['id']);
				$stmt->execute();
				
				// Set the user as connected
				$_SESSION['logged_in'] = TRUE;

				// Redirect to index.php
				header('Location: index.php');
			}
		}
	}

?>

<!DOCTYPE html>
<html>
<head>
	<?php include "head.php"; ?>

	<title>Kfet - Se connecter</title>
</head>
<body>
	<a href="login.php">Retour à l'écran de connexion</a>
	<div>
		<h1>Activation du compte</h1>
		

<?php 

	$error = FALSE;
	
	if(isset($_POST['student_number'])) {

		// Make sure the submetted registerations are not empty
		if(empty($_POST['student_number'])) {
			// One or more values are empty
			exit('Please fill all the needed fields!');
		}

		// Connect to the database
		$connection = connect_to_database();
		if($connection == FALSE) {
			exit();
		}

		// Check if the user has not already a password
		$req = 'SELECT id, username, auth_level, activated FROM users WHERE student_number = ?';
		if($stmt = $connection->prepare($req)) {
			$stmt->bind_param('i', $_POST['student_number']);
			$stmt->execute();
			$stmt->store_result();

			// Check if there is someone registered with this student number
			if($stmt->num_rows == 0) {
				$error = TRUE;
				echo('Il n\'y a pas d\'utilisateur avec ce numéro d\'étudiant');
			} else {
				$stmt->bind_result($id, $username, $auth_level, $activated);
				$stmt->fetch();

				// Check if the account is not already activated
				if($activated == 1) {
					$error = TRUE;
					echo('Vous avez déjà activé votre compte');
				} else {
					$_SESSION['username'] = $username;
					$_SESSION['id'] = $id;
					$_SESSION['auth_level'] = $auth_level;
				}
			}
		}

		if($error == FALSE) {
?>
		<form action="activate.php" autocomplete="off" method="post">
			<input type="hidden" name="student_number" value="<?php echo htmlspecialchars($_POST['student_number']); ?>">

			<label for="password">Choississez un mot de passe</label>
			<input type="password" name="password" id="password" required>
			
			<input type="submit" value="Valider">
		</form>
<?php
		}
	}
	
	if(!isset($_POST['student_number']) || $error == TRUE) {
	// This is step one :
	// The user gives their student number
?>
		<form action="activate.php" autocomplete="off" method="post">
			<label for="student_number">Numéro étudiant</label>
			<input type="text" name="student_number" placeholder="182355" id="student_number" required>
			
			<input type="submit" value="Suivant">
		</form>
<?php
	}
?>

	</div>
</body>
</html>