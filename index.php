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
			$actualPrice = (isset($_SESSION['bdlc_member']) && $_SESSION['bdlc_member']) ? $row['bdlc_price'] : $row['price'];
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
      <img class="index-profile-picture" src="res/icons/person-circle-outline.svg">

      <div class="content">
          <h4 class="index-name"><?php echo htmlspecialchars($_SESSION['username']); ?></h4>
          <h4 class="index-money">Solde : <?php echo htmlspecialchars($_SESSION['credit']); ?> €</h4>
      </div>
  </div>

	<div id="home" class="default-linked-section linked-section">
		<!-- Identification de l'étudiant -->
			
        <!-- Evénéments à promouvoir ou des rappels! Exemple : mardi/jeudi viennoiseries, wei, etc -->
        <?php

        // Know if there is an event
        $result = $mysqli->query('SELECT COUNT(*) FROM events');
        $count = intval($result->fetch_array()[0]);

        if($count != 0) {
        ?>

		<div class="sub-categories carousel slide carousel-dark" data-ride="carousel" id="event">
			<h4 class="sub-categories-title">Evénements</h4><span class="menuspan" id="span-event"></span>

            <!-- Indicators -->
            <ul class="carousel-indicators">
                <?php
                for ($i = 0; $i < $count; $i++) {
                    echo ($i == 0) ? '<li data-target="#event" data-slide-to="0" class="active"></li>' :
                        '<li data-target="#event" data-slide-to="'. $i .'"></li>';
                }
                ?>
            </ul>

            <!-- The slideshow -->
            <div class="carousel-inner">
                <?php

                    $result = $mysqli->query('SELECT * FROM events');
                    $i = 0;
                    while($event = $result->fetch_assoc()) {
                        if($i == 0) {
                            echo '<div class="carousel-item active">';
                        } else {
                            echo '<div class="carousel-item">';
                        }

                        $i++;
                        echo '<img src="res/images/events/'. $event['image'] .'" alt="'. $event['name'] .'">';
                        echo '</div>';
                    }
                ?>
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
        }   // End of the if statement for the event(s)

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

									<div title="<?php echo(htmlspecialchars($name)); ?>" class="sub-presentation-card clickable" id="<?php echo $id; ?>" onclick="showItemDetails(<?php echo htmlspecialchars($id); ?>,'<?php echo htmlspecialchars($name); ?>', <?php echo htmlspecialchars($actualPrice); ?>, '<?php echo htmlspecialchars($image) ?>')">
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
			<h4 class="mt-3 sub-categories-title centered-text underline mx-auto" style="width: 80%">Catégories</h4>

			<div class="row">
                <div class="col">
				    <img class="w-100 rounded d-block clickable" src="res/images/categories/boissons_chaudes.png"
                         onclick="window.location = 'index.php#hot-drinks';">
                </div>
                <div class="col">
                    <img class="w-100 rounded d-block clickable" src="res/images/categories/boissons_froides.png"
                         onclick="window.location = 'index.php#cold-drinks';">
                </div>
            </div>
			<div class="row">
                <div class="col">
                    <img class="w-100 rounded d-block clickable" src="res/images/categories/snacks.png"
                         onclick="window.location = 'index.php#snacks';">
                </div>
                <div class="col">
                    <img class="w-100 rounded d-block clickable" src="res/images/categories/formules.png"
                         onclick="window.location = 'index.php#formules';">
                </div>
			</div>		
		</div>
	</div>

	<div id="shop">
		<div id="hot-drinks" class="linked-section">
			<div class="return-button clickable" onclick="window.location = 'index.php#';">
				<i class="fas fa-undo-alt"></i><p>Retour vers le menu</p>
			</div>

			<div class="header">
	            <h1>Les boissons chaudes</h1>
	        </div>
	   	
	        <?php displayCategory(0); ?>
		</div>
		<div id="cold-drinks" class="linked-section">
			<div class="return-button clickable" onclick="window.location = 'index.php#';">
				<i class="fas fa-undo-alt"></i><p>Retour vers le menu</p>
			</div>

			<div class="header">
	            <h1>Les boisons froides</h1>
	        </div>
	  	
	  	    <?php displayCategory(1); ?>
	  </div>
		<div id="snacks" class="linked-section">
			<div class="return-button clickable" onclick="window.location = 'index.php#';">
				<i class="fas fa-undo-alt"></i><p>Retour vers le menu</p>
			</div>

			<div class="header">
	            <h1>Les trucs à grignoter</h1>
            </div>
	   
	   	    <?php displayCategory(2); ?>
		</div>
		<div id="formules" class="linked-section">
			<div class="return-button clickable" onclick="window.location = 'index.php#';">
				<i class="fas fa-undo-alt"></i><p>Retour vers le menu</p>
			</div>

			<div class="header">
	            <h1>Formules</h1>
	        </div>

            <?php displayCategory(3); ?>
		</div>
    </div>

	</div>
	
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

	<div class="modal fade" id="order-summary">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h3 class="modal-title" id="item-details-name">Panier</h3>
					<button type="button" class="close" data-dismiss="modal" onmouseup="toggleShop()">
          	            <span>&times;</span>
        	        </button>
				</div>
				<div class="modal-body p-4">
                    <form id="order-summary-form" method="post" action="lib/command.php">
						<div class="list-group-flush" id="order-summary-content">
						</div>
					</form>
					<h5 class="float-right mt-3 mr-2">Prix total : <span id="order-summary-total" class="font-weight-bold"></span> €</h5>

                    <button class="float-right mr-2 btn-outline-secondary btn-sm btn" onclick="cancelOrder()">Annuler la commande</button>
                </div>
			</div>	
		</div>
	</div>

	<div class="shoping-cart clickable">
		<div class="icon" onmouseup="toggleShop()">
			<span class="fa-layers fa-fw">
		    <i id="cart-icon" class="fas fa-shopping-cart"></i>
		    <span class="fa-layers-counter" id="cart-number-item"></span>
		  </span>
		</div>

		<div class="icon icon-check" id="check-icon" onmouseup="submitForm()">
			<span id="" class="fa-layers fa-fw">
		    <i class="fas fa-check" id="shopping-cart"></i>
		  </span>
		</div>
	</div>	

	

<script type="text/javascript" src="js/linked_sections.js"></script>
<script type="text/javascript" src="js/shopping.js"></script>
<script src="js/status_message.js"></script>
<script type="text/javascript">
	addStatusMessage('command', {
        'cacolac_1' : 'T\'as vraiment pris un cacolac ??!!!',
        'cacolac_2' : 'Cacolac = meilleure boisson <3',
        'success_order' : 'Commande passée avec succès !',
        'database_error_1' : 'Il y a eu un problème avec la base de donnée ... (1)',
        'database_error_2' : 'Il y a eu un problème avec la base de donnée ... (2)',
        'database_error_3' : 'Il y a eu un problème avec la base de donnée ... (3)',
        'database_error_4' : 'Il y a eu un problème avec la base de donnée ... (4)',
        'database_error_5' : 'Il y a eu un problème avec la base de donnée ... (5)',
        'database_error_6' : 'Il y a eu un problème avec la base de donnée ... (6)',
        'not_enough_money' : 'Il semble que vous soyez trop pauvre ! Demandez à un.e barista de vous rajouter de l\'argent.',
        'empty_order' : 'Vous venez vraiment de passer une commande avec rien ?!! --\''
    })
</script>
</body>
</html>