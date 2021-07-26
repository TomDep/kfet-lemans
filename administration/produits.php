<?php
	require_once('connect.php');
?>

<h1>Produits</h1>

<div class="add-product">
	<h2>Ajouter un produit</h2>
	<form action="../add_product.php" method="post" enctype="multipart/form-data" autocomplete="off">
	
		<label for="product_name">Nom du produit</label>
		<input type="text" name="product_name" placeholder="Café" id="product_name" required>

		<label for="product_price">Prix</label>
		<input type="number" step=".01" name="product_price" placeholder="0.40" id="product_name" required>

		<label for="product_category">Catégorie</label>
		<select id="product_category" name="product_category" required>
			<option value="0">Boisson chaude</option>
			<option value="1">Boisson froide</option>
			<option value="2">Snack</option>
		</select>

		<label for="product_image">Image</label>
		<input type="file" name="product_image" id="product_image" required>
		
		<input type="submit" value="Ajouter">
	</form>
</div>

<div class="product-list">
	<h2>Liste des produits</h2>

	<form action="#produits" method="get">
		<label for="search">Rechercher</label>
		<input type="text" name="search" id="search" placeholder="Café, Cookie ...">		
	
		<input type="submit" value="Rechercher">
	</form>

	<form action="#produits" method="get">
		<label for="sort">Trier par</label>
		<select id="sort" name="sort">
			<option value="name">Nom</option>
			<option value="price">Prix</option>
			<option value="category">Catégorie</option>
		</select>

		<input type="submit" value="Trier">
	</form>

	<table>
		<tr>
			<th>Nom</th>
			<th>Prix</th>
			<th>Catégorie</th>
			<th>Image</th>
		</tr>

<?php

	// Display every products of the database

	// Connect to the database
	$connection = connect_to_database();
	if($connection == FALSE) {
		exit();
	}

	$req = 'SELECT * FROM products';
	if($stmt = $connection->prepare($req)) {
		$stmt->execute();
		$stmt->bind_result($id, $name, $price, $category, $image_path);
		while($stmt->fetch()) {
?>
		<tr>
			<td><?php echo htmlspecialchars($name); ?></td>
			<td><?php echo htmlspecialchars($price) . '€'; ?></td>
			<td>
<?php
	switch ($category) {
		case 0:
			$categoryName = 'Boisson chaude';
			break;
		case 1:
			$categoryName = 'Boisson froide';
			break;
		case 2:
			$categoryName = 'Snack';
			break;
		default:
			$categoryName = 'Inconnue';
			break;
	}

	echo htmlspecialchars($categoryName); 
?>			</td>
			<td><?php echo '<img src="res/images/products/' . htmlspecialchars($image_path) . '">'; ?></td>
		</tr>
<?php
		}

		$stmt->close();
	}

	$connection->close();
?>

		
	</table>	
</div>