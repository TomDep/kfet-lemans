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
			<form class="standard-form" action="lib/authenticate.php" method="post">
				<h1 id="title"></h1>

				<div class="form-group">
				    <label>Numéro étudiant</label>
				    <input type="text" name="student_number" class="form-control input-lg" placeholder="182355" required>
				</div>

				<div class="form-group">
				    <label>Mot de passe</label>
				    <input type="password" name="password" class="form-control" id="password" placeholder="Shhh! C'est secret" required>

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


<script type="text/javascript">
	var i = 0;
	var txt = "Bienvenue !";
	var speed = 100;

	function typeWriter() {
	  if (i < txt.length) {
	    document.getElementById("title").innerHTML += txt.charAt(i);
	    i++;
	    setTimeout(typeWriter, speed);
	  }
	}

	typeWriter();

</script>

</html>

