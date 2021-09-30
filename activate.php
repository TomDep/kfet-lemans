<?php
	session_start();

	require_once('lib/connect.php');

	function activateAccount($studentNumber, $password) {
		$mysqli = connectToDatabase();

		mysqli_report(MYSQLI_REPORT_ERROR);

		$activated = TRUE;

		// Check if the user account is already activated
		if($stmt = $mysqli->prepare('SELECT activated FROM users WHERE student_number = ?')) {
			$stmt->bind_param('i', $studentNumber);
			if(!$stmt->execute()) {
				return FALSE;
			}

			$stmt->bind_result($activated);
			$stmt->fetch();
		} else {
			return FALSE;
		}

		$stmt->close();	
		
		if($activated == '0') {
			$req = 'UPDATE users SET password = ?, activated = 1 WHERE student_number = ?';
			$stmt = $mysqli->prepare($req);
			if($stmt) {
				$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
				$stmt->bind_param('si', $password, $studentNumber);
				if(!$stmt->execute()) {
					echo $mysqli->error;
					return FALSE;
				} else {
					// Return a success
					return TRUE;
				}
			}
		}

		return FALSE;
	}

	// Check if the user is already connected
	if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == TRUE) {
		// If it is, redirect to the home page
		header('Location: index.php');
	}

	// Check if the fields are set
	if(isset($_POST['student_number'], $_POST['password'])) {
		// Check if the password field is filled
		if(!empty($_POST['password'])) {
			$success = activateAccount($_POST['student_number'], $_POST['password']);
			if($success) {
				header('Location: login.php?activate_status=success');
			} else {
				header('Location: login.php?activate_status=error');
			}
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<?php include "templates/head.php"; ?>
	<title>Kfet - Activation du Compte</title>
</head>
<body>
	<img src="res/icon.svg" id="biggerLogo">

    <section>
    	<form action="activate.php" method="post" class="standard-form" autocomplete="off">		
    		<a href="login.php">Retour à l'écran de connexion</a>

    		<h1>Activation du compte</h1>

			<div class="form-group">
			    <label>Numéro d'étudiant.e</label>
			    <input type="text" name="student_number" class="form-control input-lg" placeholder="182355" required>			
			
			    <label>Choisi un mot de passe</label>
			    <input type="password" name="password" id="password" class="form-control input-lg" placeholder="Shhh! C'est secret" required>
			</div>

			<div class="text-center">		  	
				<input id="btn-validate-lg" type="submit" value="Valider" id="btn-validate-lg">
			</div>
		</form>


<?php 

	if(isset($databaseError)) {
		echo '<small class="text-danger">Error : '. $mysqli->error .'</small>';
	}

	if(isset($alreadyActivatedError)) {
		echo '<small class="text-danger">Erreur : le compte est déjà activé.</small>';
	}

	if(isset($alreadyActivatedError) || isset($databaseError)) {
		//header('Location: login.php?activate_status=error');
	}

?>
	</section>
</body>
</html>
