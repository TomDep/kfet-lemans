<?php

	session_start();
	require_once('lib/redirect.php');
	auth_level(1);
?>

<!DOCTYPE html>
<html>
<head>
	<?php include "templates/head.php";?>

	<title>Kfet - Ajout d'un.e utilisateurice</title>
</head>
<body>
	<?php include "templates/nav.php";?>

    <section>
		<div class="margin-top">
			<form class="standard-form" action="lib/simple_user_add.php" method="post">
				<h1>Ajout d'un.e utilisateurice</h1>

					<div class="form-group">
					    <label>Numéro étudiant.e</label>
					    <input type="text" name="student_number" class="form-control input-lg" placeholder="182355" required>
					</div>

					<div class="form-group">
					    <label>Nom complet</label>
					    <input type="text" name="username" class="form-control" id="formGroupExampleInput2" placeholder="Tom de Pasquale" required>
					</div>

                    <div class="ml-4 mt-2 form-check form-group">
                        <input type="checkbox" style="width: 30px" name="bdlc_member" class="form-check-input">
                        <label class="form-check-label" style="margin-left: 15px">Adhérent.e au BDLC</label>
                    </div>

                <div class="text-center">
				  		<input type="submit" value="Ajouter" id="btn-validate-lg">
				  	</div>
			</form>
		</div>
	</section>
	<script src="js/status_message"></script>
    <script type="text/javascript">
         addStatusMessage('add', {
            'success' : 'L\'utilisateurice a bien été ajouté.e !',
            'error' : 'Il y a eu un problème lors de l\'ajout ...'
        })
    </script>
</body>
</html>