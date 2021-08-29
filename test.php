<!DOCTYPE html>
<html>

<head>
	<?php include "templates/head.php";?>
	<title>Kfet - Accueil</title>
</head>

<body>
	<?php include "templates/nav.php";?>

    <section>
		<div class="add-user" style="margin-top:80px;">
			<form action="register.php" method="post">
				<h1>Ajout d'un nouveau camarade</h1>

					<div class="form-group">
					    <label>Numéro étudiant</label>
					    <input type="text" name="student_number" class="form-control input-lg" placeholder="182355" required>
					</div>

					<div class="form-group">
					    <label>Nom complet</label>
					    <input type="text" name="username" class="form-control" id="formGroupExampleInput2" placeholder="Tom de Pasquale" required>
					</div>
					<div class="form-group">
				  		<label class="my-1 mr-2" for="inlineFormCustomSelectPref">Permission</label>
						<select class="custom-select my-1 mr-sm-2" id="inlineFormCustomSelectPref" name="auth_level">
						    <option value="0" selected>Ensimien</option>
						    <option value="1">Barista</option>
						    <?php
							// Add the administrator only if the administrator is logged on
							//if(isset($_SESSION['auth_level']) && $_SESSION['auth_level'] > 1)
								//echo '<option value="2">Administrateur</option>';
							?>
						</select>
					</div>
					<div class="form-group text-center">
					    <label class="form-check-label" for="customControlInline">
					    	<input class="form-check-input" type="checkbox" value="" id="defaultCheck1">Membre BDLC
					    </label>
					</div>
				  
				  	<div class="text-center">
				  		<input type="submit" value="Ajouter" id="btn-validate-lg">
				  	</div>

				  	<div class="form-row">
					    <div class="form-group text-center">
					      	<input type="submit" value="Annuler" id="btn-cancel-sm">
					    </div>
					    <div class="form-group text-center">
					      	<input type="submit" value="Oui" id="btn-validate-sm">
					    </div>
				  </div>
			</form>
		</div>
	</section>

</body>
</html>

<!--

Working index version for adding someone

<?php
	/*session_start();

	if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == FALSE) {
		header('Location: login.php');
	}*/
?>

<!DOCTYPE html>
<html>
	<head>
		<?php //include "templates/head.php"; ?>
		<title>Kfet - Accueil</title>
	</head>

	<body>
	<?php //include "templates/nav.php";?>
    <section>
			<form action="register.php" method="post">
				<h1>Ajout d'un nouveau camarade</h1>

				<div class="form-group">
				    <label>Numéro étudiant</label>
				    <input type="text" name="student_number" class="form-control input-lg" placeholder="182355" required>
				</div>

				<div class="form-group">
				    <label>Nom complet</label>
				    <input type="text" name="username" class="form-control" placeholder="Tom de Pasquale" required>
				</div>
				<div class="form-group">
			  		<label class="my-1 mr-2" for="inlineFormCustomSelectPref">Permission</label>
					<select class="custom-select my-1 mr-sm-2" name="auth_level">
					    <option value="0" selected>Ensimien</option>
					    <option value="1">Barista</option>
					    <?php
						// Add the administrator only if the administrator is logged on
						//if(isset($_SESSION['auth_level']) && $_SESSION['auth_level'] > 1)
							//echo '<option value="2">Administrateur</option>';
						?>
					</select>
				</div>
				<div class="form-group text-center">
				    <label class="form-check-label">
				    	<input class="form-check-input" type="checkbox" value="">Membre BDLC
				    </label>
				</div>
			  
		  	<div class="text-center">
		  		<input type="submit" value="Ajouter" id="btn-validate-lg">
		  	</div>

		  	<div class="form-row">
			    <div class="form-group text-center">
			      	<input type="submit" value="Annuler" id="btn-cancel-sm">
			    </div>
			    <div class="form-group text-center">
			      	<input type="submit" value="Oui" id="btn-validate-sm">
			    </div>
		  	</div>
			</form>
		</section>

	</body>
</html>

-->