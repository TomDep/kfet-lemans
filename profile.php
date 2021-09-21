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
		.profile-section{
			width: calc(100% - 40px);
			margin: 0 20px;
			margin-top: 50px;
		}

		.profile-section .profile-picture{
			position: fixed;
			left: calc(50% - 60px);
			width: 120px;
			margin: auto;
		}

		.profile-section img{
			border-radius: 50%;
			height: 120px;
			width: 120px;
			filter: drop-shadow(0px 4px 4px rgba(0, 0, 0, 0.25));
		}


		.profile-section h2{
			font-size: 18px;
			text-align: center;
			margin-top: 130px;
			font-weight: bold;
		}

		.profile-section p{
			margin-bottom: 5px;
			font-size: 12px;
		}

		.profile-section h2,
		.profile-section p{
			margin-left:  10px;
			width:  calc(100% - 40px);
		}


		.profile-background{
			position: fixed;
			top: 160px;
			height: 180px;
			background-color: white;
			width: calc(100% - 40px);
			z-index: -1;
			filter: drop-shadow(0px 4px 4px rgba(0, 0, 0, 0.25));
          	border-radius: 10px;
          	margin: 0 -20px;
		}

		@media (min-width: 800px){
			.profile-background{
				left: calc((100% - 450px) / 2 + 20px);

				height: 200px;
				max-width: 450px;

				border-radius: 3%;
			}

			.profile-section h2,
			.profile-section p{
				margin-left: 30%;
				width:  40%;
			}

			.profile-section h2{
				margin-bottom: 20px;
			}

			.profile-section p{
				margin-left: 37%;
			}


		}

		.profile-settings{
			width: calc(100% - 40px);
			margin: 50px 20px 0 20px;
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

		.grey-section{
			display:flex;
			justify-content:center;
			align-items:center;
			height: 100px;
			padding: 10px;
			margin: 150px 20px 50px 20px;

			background-color: #777;
			width: calc(100% - 40px);
		}

		.grey-section p{
			font-weight: bold;
			font-size: 10px;
		}

		@media (min-width: 1000px){
			.profile-settings, 
			.grey-section{
				width: 30%;
			}
		}

		.container{
			display: flex;
			flex-direction: column;
			padding: 0;
			align-items: center;
			margin-top: 60px;
			height: calc(100vh - 60px);
			width: calc(100% - 40px);
			max-width: 1500px;
		}
	</style>
</head>
<body>
	<?php include "templates/nav.php";?>

	<div class="container">
		<div class="profile-section">
			<div class="profile-picture" id="profile-picture">
				<img src="https://www.bolde.com/wp-content/uploads/2020/09/iStock-1269607964-400x400.jpg">	
			</div>


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

			<div class="profile-background"></div>
		</div>

		<div class="profile-settings">
			<h6 class="text-center" style="border-bottom:1px solid black">Paramètres</h6>
			<p class="text-center"><a href="edit_password.php">Modifier mon mot de passe</a></p>
			<!--<p class="text-center"><a href="edit_password.php">Ajouter de l'argent au compte</a></p>-->
		</div>

		<div class="grey-section">
			<p>Pssst! <br> Pour ajouter de l'argent à ton solde...<br> Demande aux baristas ! ;)</p>
		</div>

	</div>
	
</body>

<script type="text/javascript">
	/*
	var auth_level = "<?php echo $_SESSION['auth_level']; ?>";
    var pic = document.getElementById("profile-picture").childNodes; 

    // Randomize pictures for profile   
    var src = "https://i.pinimg.com/originals/6d/d5/94/6dd5949d423e3a8f0e6863ff75e0b24d.jpg";
    pic[1].setAttribute("src",src);


    // Generate random colors 
    var arrayColor = new Array(3);
    for(var i=0;i<3;i++){
    	arrayColor[i] = Math.floor(Math.random() * 256);
    }
    var color = "rgb(" + arrayColor[0] + "," + arrayColor[1] + "," + arrayColor[2] + ")";
    pic[1].style.backgroundColor = color;
    */
</script>

</html>