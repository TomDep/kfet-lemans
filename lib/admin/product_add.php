<?php

    // Errors
    $errorMessage = '';
    $databaseError = false;
    $emptyValueError = false;
    $fileError = false;
    
    // Include lib files
    require_once('../connect.php');
    require_once('../util.php');
    require_once('../file.php');

    // Connect to the database
    if(!$mysqli = connectToDatabase()) {
        $databaseError = true;
        $errorMessage = 'Unable to connect to the database';
    }
    
    if(isset($_POST['name'], $_POST['price'], $_POST['bdlc_price'], $_POST['category'], $_FILES['image'])) {
        
        // Add the image
        saveFile('../../res/images/products/', $_FILES['image'], $_POST['name']);
        $extansion = getFileExtansion($_FILES['image']['name']);

        if(!insert($mysqli, 'products', array(
            array('key' => 'name', 'value' => $_POST['name']), 
            array('key' => 'price', 'value' => $_POST['price']), 
            array('key' => 'bdlc_price', 'value' => $_POST['bdlc_price']), 
            array('key' => 'category', 'value' => $_POST['category']), 
            array('key' => 'image', 'value' => $_POST['name'] . '.' . $extansion)
        ))) {
            $databaseError = true;
            $errorMessage = 'Unable to insert the product';
        }
        
        //$mysqli->query("INSERT INTO products (name, price, bdlc_price, category, image) VALUES ('a' ,'5' ,'5' ,'0' ,'soda.jpg')");
    }

    if($databaseError || $emptyValueError || $fileError) {
        header('Location: ../../administrate_products.php?add_status=error');
    } else {
        header('Location: ../../administrate_products.php?add_status=success');
    }
?>