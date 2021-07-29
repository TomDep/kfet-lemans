<?php

header("Content-Type: text/html; charset=utf-8");
require_once('connect.php');

// Test if all data was submitted
if(!isset($_POST['product_name'], $_POST['product_price'], $_FILES['product_image'], $_POST['product_category'])) {
	// Could not get the data that should have been sent.
	exit('Please fill all the required fields!');
}

var_dump($_POST);

// Check if the data is not empty
if(empty($_POST['product_name']) || empty($_POST['product_price'])) {
	// One the field is not filled
	exit('Please fill all the fields !');
}

// Connect to the database
$connection = connectToDatabase();
if($connection == FALSE) {
	exit();
}

// Check if there is already a product with this name
$req = 'SELECT id FROM products WHERE name = ?';
if($stmt = $connection->prepare($req)) {
	$stmt->bind_param('s', $_POST['product_name']);
	$stmt->execute();
	$stmt->store_result();

	// Store the result so we can check if the products exists in the database.
	if($stmt->num_rows > 0) {
		// Product already exists
		$stmt->close();

		exit('The product already exists');
	}
}

// Upload the file to the server 
$dir = 'res/images/products/';
$imageFileType = strtolower(pathinfo($_FILES['product_image']['name'] ,PATHINFO_EXTENSION));
$path = $dir . $_POST['product_name'] . '.' . $imageFileType;

var_dump($path);

if(!move_uploaded_file($_FILES['product_image']['tmp_name'], $path)) {
	// Error while uploading the file
	exit('Couldn\'t upload the file to the server !');
}

// Prepare our SQL, preparing the SQL statement will prevent SQL injection.
$req = 'INSERT INTO products (name, price, category, image) VALUES (?, ?, ?, ?)';
if ($stmt = $connection->prepare($req)) {

	// Bind parameters
	$image = $_FILES['product_image']['name'];
	$stmt->bind_param('sdis', htmlspecialchars($_POST['product_name']), $_POST['product_price'], $_POST['product_category'], $image);
	if($stmt->execute() == FALSE) {
		exit('Could not INSERT a new product to the database');
	}

	echo 'Le produit "' . htmlspecialchars($_POST['product_name']) . '" a bien été ajouté à la base de donnée !';
	$stmt->close();
	$connection->close();
}

?>