<?php
	session_start();

	// Redirect if the user isn't connected
	if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] != TRUE) {
		header('Location: login.php');
	}
?>

<!DOCTYPE html>
<html>
<head>
	<?php include "templates/head.php"; ?>

	<title>Kfet - Mon Compte</title>

	<style type="text/css">
		.profile-container{
			display: flex;
			flex-direction: column;
			padding: 0;
			align-items: center;
			
			margin: 60px 20px 0 20px;
		}

		.profile-section{
			width: calc(100% - 40px);
			margin: 50px 20px 0 20px;
			background-color: white;
			border-radius: 10px;
		}

		.profile-section h2{
			font-size: 18px;			
			font-weight: bold;

			text-align: center;

			padding: 30px 0;
			margin-bottom: 0;
		}

		.profile-section p{			
			font-size: 12px;

			width:  calc(100% - 40px);

			margin-bottom: 5px;
			margin-left:  15px;
		}

	

		.profile-settings{
			width: calc(100% - 40px);
			margin: 20px 20px 0 20px;
		}

		.profile-settings p{			
			border-radius: 10px;
			background-color: white;
			cursor: pointer;
			font-weight: bold;
			margin: 5px 0;
			margin-bottom: 10px;
		}

		.profile-settings p a{
		    text-decoration: none;
		    font-size: 12px;
		    color: black;
		}

		.profile-settings p a:hover{
		    text-decoration: underline;
		}

		@media (min-width: 700px){
			.profile-container{
				padding-top: 50px;
			}

			.profile-section,
			.profile-settings{
				width: 25%;
			}

			.profile-section h2,
			.profile-section p{
				width:  100%;
			}

			.profile-section p{
				margin-left: 15px;
			}
		}
	</style>
</head>
<body>
	<?php include "templates/nav.php";?>

	<div class="profile-container">
		<div class="profile-section">
			<?php
			// User's informations
			echo '<h2>' . htmlspecialchars($_SESSION['username']) . '</h2>';

			echo '<p><b>Solde actuel</b>: ' . htmlspecialchars($_SESSION['credit']) . '€</p>';

			echo '<p><b>Status BDLC</b>: ';
			echo ($_SESSION['bdlc_member']) ? 'Adhérent.e' : 'Non adhérent.e';
			echo '</p>';

			echo '<p><b>Status du compte</b>: ';

			switch ($_SESSION['auth_level']) {
				case 0:
					echo 'Ensimien.ne';
					break;
				case 1:
					echo 'Barista';
					break;
				case 2:
					echo 'Administrateurice';
					break;
			}
			echo '</p>';
			?>

			<br><p>Pssst! Pour ajouter de l'argent à ton solde... <br> Demande directement aux baristas! ;)</p><br>
		</div>

		<div class="profile-settings">
			<h6 class="text-center" style="border-bottom:1px solid black">Paramètres</h6>
			<p class="text-center"><a href="edit_password.php">Modifier mon mot de passe</a></p>
			<!--<p class="text-center"><a href="edit_password.php">Ajouter de l'argent au compte</a></p>-->
		</div>

	</div>
	
</body>
</html>