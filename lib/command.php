<?php

    // Get the user informations
    session_start();

    // Connect to the database
    require_once('connect.php');
    $mysqli = connectToDatabase();

    // Check if the user is logged-on
    if(!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
        // Return to loggin screen
        header('Location: ../login.php');
    }

    $user_id = $_SESSION['id']; // Get the user id

    // Get the command of the users
    $products = [];
    $total_price = 0;

    foreach ($_POST as $id => $quantity) {
        $products[$id] = $quantity;

        // TODO add a verification system

        // Get the total price of the order
        $result = $mysqli->query('SELECT price, bdlc_price FROM products WHERE id=' . $id);
        $row = $result->fetch_array();
        $total_price += $quantity * (($_SESSION['bdlc_member']) ? $row['bdlc_price'] : $row['price']);
    }

    if(count($products) == 0) header('Location: ../index.php?emptyOrder');

    // Get the user credits
    $result = $mysqli->query('SELECT credit FROM users WHERE id='. $_SESSION['id']);
    $credit = $result->fetch_array()['credit'];

    // Check if the user has enough money
    if($credit < $total_price) {
        // Redirect the user to the home page
        header('Location: ../index.php?notEnoughMoney');
    } else {
        // Remove the money from the account
        $mysqli->query('UPDATE users SET credit=credit-' . $total_price . ' WHERE id=' . $_SESSION['id']);
    }

    // Get the current datetime
    $datetime = date('Y-m-d H:i:s');

    // Create an order
    if(!$mysqli->query('INSERT INTO orders (user_id, datetime) VALUES ('. $user_id .', "'. $datetime .'")')) {
        echo 'Error : ' . $mysqli->error;
    }
    
    $result = $mysqli->query('SELECT id FROM orders WHERE datetime="'. $datetime .'"');
    $order_id = $result->fetch_array()['id'];

    // Create a new item_order for each product
    foreach ($products as $id => $quantity) {
        $mysqli->query('INSERT INTO item_orders (order_id, product_id, quantity) VALUES ('. $order_id .', '. $id .', '. $quantity .')');
    }

    // Redirect to home page
    header('Location: index.php');
?>