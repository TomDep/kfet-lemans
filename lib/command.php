<?php

    // Get the user informations
    session_start();

    // Connect to the database
    require_once('connect.php');
    $mysqli = connectToDatabase();
    mysqli_report(MYSQLI_REPORT_ERROR);

    // Check if the user is logged-on
    if(!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
        // Return to loggin screen
        header('Location: ../login.php');
    }

    $user_id = $_SESSION['id']; // Get the user id
    // Get the command of the users

    // Go through each ids and add a ? to the request
    // All ids are stored in an array
    // If an id value is not a number, return an error
    $req = "SELECT price, bdlc_price FROM products WHERE id IN (";
    $product_ids = [];
    $product_quantities = [];
    $i = 0;

    foreach ($_POST as $id => $quantity) {
        // Check if the quantity is a number
        if(!is_numeric($quantity)) header('Location: ../index.php?command_status=invalid');

        // Build the request
        $req .= ($i++ == 0) ? "?" : ", ?";
        $product_ids[] = $id;   // Create the id array
        $product_quantities[] = $quantity;
    }

    // We should get a request of the form SELECT .. FROM .. WHERE id IN (?, ?, .., ?)
    $req .= ")";
    $parameterTypes = str_repeat("i", count($product_ids)); // Create a string for the binding of parameters

    // Check if the command is empty
    var_dump($product_ids);
    if(count($product_ids) == 0) {
        header('Location: ../index.php?command_status=empty_order');
        exit();
    }

    // Create the statement and calculate the total price
    $total_price = 0;
    $i = 0;

    if($stmt = $mysqli->prepare($req)) {
        $stmt->bind_param($parameterTypes, ...$product_ids);
        $stmt->execute();
        $stmt->bind_result($price, $bdlc_price);
        while($stmt->fetch()) {
            $total_price += (($_SESSION['bdlc_member']) ? $bdlc_price : $price) * $product_quantities[$i];
            $i++;
        }
    } else {
        // Database error
        header('Location: ../index.php?command_status=database_error_1');
        exit();
    }

    // Check if the user has enough credit on their account

    // Get the user credits
    if($stmt = $mysqli->prepare("SELECT credit FROM users WHERE id = ?")) {
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->bind_result($credit);
        $stmt->fetch();
    } else {
        // Database error
        header('Location: ../index.php?command_status=database_error_2');
        exit();
    }
    $stmt->close();

    // Check if the user has enough money and remove the amount from the account
    if($credit < $total_price) {
        // Redirect the user to the home page
        header('Location: ../index.php?command_status=not_enough_money');
        exit();
    } else {
        // Remove the money from the account
        if($stmt = $mysqli->prepare("UPDATE users SET credit = credit - ? WHERE id = ?")) {
            $stmt->bind_param("di", $total_price, $user_id);
            $stmt->execute();
        } else {
            // Database error
            header('Location: ../index.php?command_status=database_error_3');
            exit();
        }
    }

    // Create the command order

    // Get the current datetime
    $datetime = date('Y-m-d H:i:s');

    // Create an order
    if($stmt = $mysqli->prepare('INSERT INTO orders (user_id, datetime) VALUES (?, ?)')) {
        $stmt->bind_param("is", $user_id, $datetime);
        $stmt->execute();
    } else {
        // Database error
        header('Location: ../index.php?command_status=database_error_4');
        exit();
    }
    
    // Get the id of the newly created order
    // No need for a prepare statement given that datetime is not defined by the user
    if(!$result = $mysqli->query('SELECT id FROM orders WHERE datetime="'. $datetime .'"')) {
        // Database error
        header('Location: ../index.php?command_status=database_error_5');
        exit();
    }

    $order_id = $result->fetch_array()['id'];

    // Create a new item_order for each product
    for($i = 0; $i < count($product_ids); $i++) {
        $id = $product_ids[$i];
        $quantity = $product_quantities[$i];
        if(!$mysqli->query('INSERT INTO item_orders (order_id, product_id, quantity) VALUES ('. $order_id .', '. $id .', '. $quantity .')')) {
            // Database error
            header('Location: ../index.php?command_status=database_error_6');
            exit();
        }
    }

    // Redirect to home page

    // Check if a cacolac was purchased (id = 17)
    // This is only a joke :)
    if(in_array(17, $product_ids)) {
        if(rand(0, 1) == 1) {
            header('Location: ../index.php?command_status=cacolac_1');
        } else {
            header('Location: ../index.php?command_status=cacolac_2');
        }
    } else {
        header('Location: ../index.php?command_status=success_order');
    }
?>