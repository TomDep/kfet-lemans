<?php
	session_start();

	require_once('lib/redirect.php');
	auth_level(0);

	// Include the database connect file
	require_once('lib/connect.php');
	$mysqli = connectToDatabase();

	// Update the session variables
	$req = 'SELECT bdlc_member, credit FROM users WHERE id = ?';
	if($stmt = $mysqli->prepare($req)) {
		$stmt->bind_param('i', $_SESSION['id']);
		$stmt->execute();

		$stmt->bind_result($bdlc_member, $credit);
		while($stmt->fetch()) {
			$_SESSION['bdlc_member'] = $bdlc_member;
			$_SESSION['credit'] = $credit;
		}
	}
	
	function displayCategory($category) {
		// Get all products
		$mysqli = connectToDatabase();

		$result = $mysqli->query('SELECT * FROM products WHERE category = ' . $category);
		while($row = $result->fetch_assoc()) {
			$actualPrice = ($_SESSION['bdlc_member']) ? $row['bdlc_price'] : $row['price'];
?>
<div class="presentation-card" id="<?php echo htmlspecialchars($row['id']); ?>" onclick="showItemDetails(<?php echo htmlspecialchars($row['id']); ?>,'<?php echo htmlspecialchars($row['name']); ?>', <?php echo htmlspecialchars($actualPrice); ?>, '<?php echo htmlspecialchars($row['image']) ?>')">
  <img class="card-picture" id="card-picture" src="res/images/products/<?php echo htmlspecialchars($row['image']); ?>">
  <div class="content">
      <h4 class="card-name"><?php echo htmlspecialchars($row['name']); ?></h4>
      <h4 class="card-subtitles">Prix unitaire: <?php echo htmlspecialchars($actualPrice); ?> €</h4>
  </div> 
</div>
<?php
		}
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Kfet - Accueil</title>		

		<?php include "templates/head.php"; ?>
		<link rel="stylesheet" type="text/css" href="css/home.css" />
	</head>

	<body>

	<div id="container">
	<?php include "templates/nav.php";?>

	<div class="index-profile clickable" onclick="document.location.href = 'profile.php';">
      <img class="index-profile-picture" src="res/icon.svg">

      <div class="content">
          <h4 class="index-name"><?php echo htmlspecialchars($_SESSION['username']); ?></h4>
          <h4 class="index-money">Solde : <?php echo htmlspecialchars($_SESSION['credit']); ?> €</h4>
      </div>
  </div>

	<div id="home" class="default-linked-section linked-section">
		<!-- Identification de l'étudiant -->
			
    <!-- Evénéments à promouvoir ou des rappels! Exemple : mardi/jeudi viennoiseries, wei, etc -->
		<div class="sub-categories carousel slide " data-ride="carousel" id="event">
			<h4 class="sub-categories-title">Evénements</h4><span class="menuspan" id="span-event"></span>

		  <!-- Indicators -->
		  <ul class="carousel-indicators">
		    <li data-target="#event" data-slide-to="0" class="active"></li>
		  </ul>

		  <!-- The slideshow -->
		  <div class="carousel-inner">
		    <div class="carousel-item active">
		      <img src="res/images/events/BBQ.jpg" alt="BBQ">
		    </div>
		  </div>

		  <!-- Left and right controls -->
		  <a class="carousel-control-prev" href="#event" data-slide="prev">
		    <span class="carousel-control-prev-icon"></span>
		  </a>
		  <a class="carousel-control-next" href="#event" data-slide="next">
		    <span class="carousel-control-next-icon"></span>
		  </a>
		</div>

		
<?php
		require_once('lib/favorites.php');
		$favorites = getFavorites($_SESSION['id'], 4);

		if(count($favorites) > 0) {
?>
		<!-- La liste de mes préférés! -->
		<div class="sub-categories">		
			<h4 class="sub-categories-title">J'adore ça, donnez m'en plus!</h4><span class="menuspan" id="span-like"></span>

			<div class="favorites-items">
<?php
						foreach ($favorites as $favorite_id => $quantity) {
							$query = 'SELECT id, image, name, price, bdlc_price, category FROM products WHERE id = ?';
							if($stmt = $mysqli->prepare($query)) {
								$stmt->bind_param('i', $favorite_id);
								$stmt->execute();
								$stmt->bind_result($id, $image, $name, $price, $bdlc_price, $category);

								while ($stmt->fetch()) {
									$actualPrice = ($_SESSION['bdlc_member']) ? $bdlc_price : $price;
									?>

									<div title="<?php echo(htmlspecialchars($name)); ?>" class="sub-presentation-card clickable" id="<?php echo $id; ?>" onclick="addItem(<?php echo $id . ',\'' . $name . '\',\'res/images/products/' . $image . '\',' . $actualPrice; ?>, 1)">
										<img class="card-picture" src="<?php echo 'res/images/products/' . $image ;?>">
										<div class="content">
											<p class="card-name"><?php echo $name;?></p>
											<p class="card-subtitles"><?php echo $actualPrice;?>€</p>
										</div>
									</div>

								<?php
								}
							}
						}
				?>
	
			</div>

		</div>
<?php } ?>
		<!-- La répartition du shop avec mes 4 catégories -->

		<div class="sub-categories" id="categories-items">
			<h4 class="sub-categories-title centered-text underline">Catégories</h4>

			<div class="row">
				<div class="column" style="background-image:url(https://images.pexels.com/photos/585750/pexels-photo-585750.jpeg?auto=compress&cs=tinysrgb&dpr=3&h=750&w=1260);" onclick="window.location = 'index.php#hot-drinks'">
					<p>Boisson<br>Chaude</p>
				</div>
				<div class="column" 
						style="background-image:url(https://images.pexels.com/photos/7235673/pexels-photo-7235673.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940);" onclick="window.location = 'index.php#cold-drinks'">
					<p>Boisson<br>Froide</p>
				</div>
			</div>
			<div class="row">
				<div class="column" style="background-image:url(https://images.pexels.com/photos/4087610/pexels-photo-4087610.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940);" onclick="window.location = 'index.php#snacks'">
					<p>Snacks</p>
				</div>
				<div class="column" style="cursor:not-allowed;background: grey;">
					<p>Formules</p>
				</div>
			</div>		
		</div>
	</div>

	<div id="shop">
		<div id="hot-drinks" class="linked-section">

			<!--Add button to return main menu
			-->
			<div class="return-button clickable" onclick="window.location = 'index.php';">
				<i class="fas fa-undo-alt"></i><p>Retour vers le menu</p>
			</div>

			<div class="header">
	      <h1>Les boissons chaudes</h1>
	    </div>
	   	
	    <?php displayCategory(0); ?>
		</div>
		<div id="cold-drinks" class="linked-section">
			<div class="return-button clickable" onclick="window.location = 'index.php';">
				<i class="fas fa-undo-alt"></i><p>Retour vers le menu</p>
			</div>

			<div class="header">
	      <h1>Les boisons froides</h1>
	    </div>
	  	
	  	<?php displayCategory(1); ?>  
	  </div>
		<div id="snacks" class="linked-section">
			<div class="return-button clickable" onclick="window.location = 'index.php';">
				<i class="fas fa-undo-alt"></i><p>Retour vers le menu</p>
			</div>

			<div class="header">
	      <h1>Les trucs à grignoter</h1>
	    </div>
	   
	   	<?php displayCategory(2); ?>
		</div>
		<div id="formules" class="linked_section" style="display: none;">
			<div class="return-button clickable" onclick="window.location = 'index.php';">
				<i class="fas fa-undo-alt"></i><p>Retour vers le menu</p>
			</div>

			<div class="header">
	      <h1>Formules</h1>
	    </div>
	  
		</div>
  </div>

	</div>
	
	<!--
	<div id="detailed-item" class="detailed-item" >
		<div class="item-presentation">
			<img class="item-picture" id="item-picture" src="">
			<h2 class="item-name text-center" id="item-name"></h2>
		</div>

		<div class="item-description">
				<h4 class="item-price">Prix unitaire: <span id="item-price"></span>€</h4>
				<h4 class="item-quantity">Quantité: <span id="item-quantity"></span></h4>
				<div class="item-control">
					<div class="item-control-plus" onclick="quantityItem(1)"><i class="fas fa-plus"></i></div>
					<div class="item-control-minus" onclick="quantityItem(-1)"><i class="fas fa-minus"></i></div>
				</div>
				<div class="item-add">
		  		<input type="submit" value="" id="btn-validate-lg">
				</div>
		</div>
  	<div class="close" onclick="toggleItem(0,0)"><i class="fas fa-times"></i></div>
	</div>
	-->

	<div class="modal fade" id="item-details">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h3 class="modal-title" id="item-details-name">Produit</h3>
					<button type="button" class="close" data-dismiss="modal">
          	<span>&times;</span>
        	</button>
				</div>
				<div class="modal-body p-4">
					<img id="item-details-src" class="img-fluid" onerror="cantLoadImg(this)">
					<hr>
					<h5>Prix à l'unité : <span id="item-details-price">0.4€</span> €</h5>

					<div class="container mt-4">
						<div class="row justify-content-around">
							<button id="item-details-remove" type="button" class="btn btn-primary btn-round">
								<i class="fas fa-minus"></i>
							</button>
							<h4 id="item-details-quantity">1</h4>
							<button id="item-details-add" type="button" class="btn btn-primary btn-round">
								<i class="fas fa-plus"></i>
							</button>
						</div>
						<div class="row justify-content-center">
							<button id="item-details-submit" type="button" class="btn btn-primary w-100 submit-rounded">Ajouter au panier pour <span id="item-details-total">0.4</span> €</button>
						</div>
					</div>
				</div>
			</div>	
		</div>
	</div>

	<div class="shoping-cart clickable">
		<div class="icon" onmouseup="toggleShop()">
			<span id="icon" class="fa-layers fa-fw">
		    <i class="fas fa-shopping-cart" id="shopping-cart"></i>
		    <span class="fa-layers-counter" id="number-item"></span>
		  </span>
		</div>

		<div class="icon icon-check" id="check-icon" onmouseup="submitForm()">
			<span id="" class="fa-layers fa-fw">
		    <i class="fas fa-check" id="shopping-cart"></i>
		  </span>
		</div>

		<div id="order-summary">
			<h1 class="text-center">Total panier: <span id="total"></span></h1>

			<form method="post" action="lib/command.php" id="order-form">
    	</form>
    </div>
	</div>	

<script type="text/javascript" src="js/linked_sections.js"></script>
<script type="text/javascript" src="js/shopping.js"></script>
<script src="js/status_message.js"></script>
<script type="text/javascript">
	addStatusMessage('command', {
				'cacolac_1' : 'T\'as vraiment pris un cacolac ??!!!',
				'cacolac_2' : 'Cacolac = meilleure boisson <3',
        'success' : 'Votre commande a été passée avec succès !',
        'database_error_1' : 'Il y a eu un problème avec la base de donnée ... (1)',
        'database_error_2' : 'Il y a eu un problème avec la base de donnée ... (2)',
        'database_error_3' : 'Il y a eu un problème avec la base de donnée ... (3)',
        'database_error_4' : 'Il y a eu un problème avec la base de donnée ... (4)',
        'database_error_5' : 'Il y a eu un problème avec la base de donnée ... (5)',
        'database_error_6' : 'Il y a eu un problème avec la base de donnée ... (6)',
        'not_enough_money' : 'Il semble que vous soyez trop pauvre ! Demandez à un.e barista de vous rajouter de l\'argent.',
        'empty_order' : 'Vous venez vraiment de passer une commande avec rien ?!! --\''
    })

	//$('#item-details').modal();

	function cantLoadImg(img) {
		if($(img).next('.missing-img').length == 0) {
			$(img).after('<small class="missing-img text-danger">Impossible de charger l\'image.</small>')
		}

		$(img).attr('src', 'res/icon.svg')
	}

	function updateItemTotal() {
		let number = parseInt($('#item-details-quantity').text())
		let unitPrice = parseFloat($('#item-details-price').text())
		let totalPrice = unitPrice * number

		$('#item-details-total').text(totalPrice.toFixed(2))
	}

	function showItemDetails(id, name, price, imgSrc) {
		// Update the modal informations
		$('#item-details-name').text(name)
		$('#item-details-src').attr('src', 'res/images/products/' + imgSrc)
		$('#item-details-price').text(price.toFixed(2))
		$('#item-details-quantity').text(1)	// Reset the quantity to 1

		updateItemTotal()

		// Add events on buttons
		$('#item-details-add').click(function() {
			let number = parseInt($('#item-details-quantity').text())
			number++;
			$('#item-details-quantity').text(number)

			updateItemTotal()
		})

		$('#item-details-remove').click(function() {
			let number = parseInt($('#item-details-quantity').text())
			if(number > 1) number--;
			$('#item-details-quantity').text(number)

			updateItemTotal()
		})

		$('#item-details-submit').click(function() {
			let quantity = parseInt($('#item-details-quantity').text())
			addItemToCart(id, name, price, imgSrc, quantity)

			$('#item-details').modal('hide');

			// Remove the event
			$('#item-details-submit').off('click')
		})

		// Show the modal
		$('#item-details').modal();
	}

	function addItemToCart(id, name, price, imgSrc, quantity) {
	console.log('Adding the product [' + id + '] ' + quantity + ' x ' + name + ', ' + price + '€ (' + imgSrc + ')');

	// Add it to the sessionStorage

	// Check if there is already an item with this id
	let item = sessionStorage.getItem(id)

	if(item == null) {
		// Create the new item
		let data = {
			"name" : name,
			"imgSrc": imgSrc,
			"price" : parseFloat(price, 2),
			"quantity" : parseInt(quantity),
			"id" : parseInt(id)
		}

		// Add to session storage
		sessionStorage.setItem(id, JSON.stringify(data))

	} else {
		// Update the quantity
		item = JSON.parse(item)
		item.quantity = parseInt(item.quantity) + parseInt(quantity)

		// Add it back to session storage
		sessionStorage.setItem(id, JSON.stringify(item))
	}

	//debugSessionStorage()
}

	$('#item-details').on('')

</script>
</body>
</html>