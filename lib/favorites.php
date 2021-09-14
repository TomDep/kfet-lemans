<?php


// Get the favorites for a given user
function getFavorites($user_id, $limit = 5) {

    // Connect to the database
    require_once('connect.php');
    $mysqli = connectToDatabase();

    // 1. Get all of the user orders (MAX 50)
    $orders = [];
    $query = 'SELECT id FROM orders WHERE user_id = ? LIMIT 50';

    // Prepare the request 
    if(!$stmt = $mysqli->prepare($query)) {
        // Return error
    }

    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $stmt->bind_result($order_id);

    // 2. Store the order id
    while($stmt->fetch()) {
        $orders[] = $order_id;
    }

    // 3. Get all the products from each orders and store them in a dictionnary
    $products = [];

    $query = 'SELECT product_id, quantity FROM item_orders WHERE order_id = ?';
    if(!$stmt = $mysqli->prepare($query)) {
        // Return error
    }

    $stmt->bind_param('i', $order_id);
    foreach ($orders as $order_id) {
        $stmt->execute();
        $stmt->bind_result($product_id, $quantity);

        while($stmt->fetch()) {
           // Adding to the array
            if(isset($products[(string) $product_id])) {
                $products[(string) $product_id] += $quantity;  
            } else {
                $products[(string) $product_id] = $quantity;
            }
        }
    }

    // Sort the product array by quantity
    arsort($products);

    // Get only the N elements
    $favorites = array_slice($products, 0, $limit, true);
    return $favorites;
}
?>