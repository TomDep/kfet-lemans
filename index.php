<?php
	session_start();

	if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == FALSE) {
		header('Location: login.php');
	}

	// Include the database connect file
	include $_SERVER['DOCUMENT_ROOT'] . '/kfet/library/connect.php';

	function displayProductFromCategory($categoryName) {

		// Connect to the database
		if(!$connection = connectToDatabase()) {
			echo 'Erreur de la base de donnée : ' . $connection->error;
		} else {

			$isBDLCMember = FALSE;

			// Check if the user is a BDLC member
			$req = 'SELECT bdlc_member FROM users WHERE id = ?';			
			if($stmt = $connection->prepare($req)) {
				$stmt->bind_param('i', $category);
				$stmt->execute();
				$stmt->store_result();

				if($stmt->num_rows > 0) {
					$stmt->bind_result($BDLCmember);
					$isBDLCMember = ($BDLCmember) ? TRUE : FALSE;					
				}
				
				$stmt->close();
			}

			$req = 'SELECT id, name, price, bdlc_price, image FROM products WHERE category = ?';
			if($stmt = $connection->prepare($req)) {
				switch($categoryName) {
					case 'hot-drinks':
						$category = 0;
						break;
					case 'cold-drinks':
						$category = 1;
						break;
					case 'snacks':
						$category = 2;
						break;
					default:
						$category = -1;
						break;
				}

				$stmt->bind_param('i', $category);
				$stmt->execute();
				$stmt->store_result();

				if($stmt->num_rows > 0) {
					$stmt->bind_result($id, $name, $price, $bdlc_price, $image);
					while($stmt->fetch()) {

						$actualPrice = ($isBDLCMember) ? $bdlc_price : $price;
?>
						<div>
							<p><?php echo htmlspecialchars($name); ?></p>
							<p><?php echo htmlspecialchars($actualPrice) . '€'; ?></p>
							<img width="50" height="50" src=<?php echo '"res/images/products/' . htmlspecialchars($image) . '"'; ?>>
						</div>
<?php
					}
				}

			} else {
				echo 'Erreur de la base de donnée : ' . $connection->error;
			}
		}
	}
?>

<!DOCTYPE html>
<html>

<head>
	<?php include "templates/head.php"; ?>

	<!-- Test coucou -->
	<title>Kfet - Accueil</title>
</head>

<body>

	<script type="text/javascript" src="js/linked_sections.js"></script>

	<?php include "templates/nav.php";?>

    <section class="default-linked-section linked-section">
    	<h1>Bonjour <?php echo htmlspecialchars($_SESSION['username']); ?></h1>

		<div class="add-user">
			<h1>Ajouter un utilisateur</h1>
			<form action="register.php" method="post" autocomplete="off">
			
				<label for="student_number">Numéro étudiant</label>
				<input type="text" name="student_number" placeholder="182355" id="student_number" required>

				<label for="username">Nom</label>
				<input type="text" name="username" placeholder="Tom de Pasquale" id="username" required>
				
				<label for="bdlc_member">Abonné BDLC</label>
				<input type="checkbox" name="bdlc_member" id="bdlc_member">

				<label for="auth_level">Niveau d'autorisation</label>
				<select id="auth_level" name="auth_level" required>
					<option value="0">Ensimien</option>
					<option value="1">Barista</option>
					<?php
						// Add the administrator only if the administrator is logged on
						if(isset($_SESSION['auth_level']) && $_SESSION['auth_level'] > 1)
							echo '<option value="2">Administrateur</option>';
					?>
				</select>

				<input type="submit" value="Ajouter">
			</form>
		</div>

		<hr>

		<div>
			<a href="#boissons-chaudes">Boissons chaudes</a>
			<a href="#boissons-froides">Boissons froides</a>
			<a href="#snacks">Snacks</a>
			<a href="#formules">Formules</a>
		</div>
	</section>

	<section class="linked-section" id="boissons-chaudes">
		<h1>Boissons chaudes</h1>

		<a href="#">Retour</a>
<?php
		displayProductFromCategory('hot-drinks');
?>
	</section>

	<section class="linked-section" id="boissons-froides">
		<h1>Boissons froides</h1>

		<a href="#">Retour</a>
<?php
		displayProductFromCategory('cold-drinks');
?>
	</section>

	<section class="linked-section" id="snacks">
		<h1>Snacks</h1>

		<a href="#">Retour</a>
<?php
		displayProductFromCategory('snacks');
?>
	</section>

	<section class="linked-section" id="formules">
		<h1>Formules</h1>

		<a href="#">Retour</a>
	</section>

</body>
</html>