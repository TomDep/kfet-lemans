<?php
	session_start();
	session_destroy();

	if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == TRUE) {
		header('Location: index.php');
	}

?>

<!DOCTYPE html>
<html>
	<head>
		<?php include "templates/head.php"; ?>
		<title>KFet - Se connecter</title>
	</head>

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
				    	<a href="edit_password.php">Mot de passe oublié?</a>
				    </div>
				    <div class="float-left">
				    	<a href="activate.php">Première connexion?</a>
					</div>							  	
				</div>
			  
			  	<div class="text-center">
			  		<input type="submit" value="Se connecter" id="btn-validate-lg">
			  	</div>
			</form>
		</section>
	</body>
</html>

