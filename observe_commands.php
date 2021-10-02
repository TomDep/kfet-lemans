<?php
    
    session_start();

    require_once('lib/redirect.php');
    auth_level(1);
?>

<!DOCTYPE html>
<html>
<head>
    <?php include('templates/head.php') ?>
    <?php include('templates/administrate_includes.php') ?>

    <title>Voir les commandes</title>

    <link rel="stylesheet" type="text/css" href="css/administrate.css">
</head>
<body>

    <?php include('templates/nav.php') ?>

    <main>
        <div class="">

            <h2 class="text-center">Historique des commandes</h2>
            <div id="accordion">
<?php

    // Include the database connection file
    require_once('lib/connect.php');

    // Connect to the database
    if(!$mysqli = connectToDatabase()) exit();

    $req = 'SELECT * FROM orders ORDER BY datetime DESC LIMIT 50';
    $result = $mysqli->query($req);

    if(!$result) {
        echo '<small class="text-danger">Error : '. $mysqli->error .'</small>';
        exit();
    }

    // Create a number formater for all the prices
    $fmt = new NumberFormatter( 'fr_FR', NumberFormatter::CURRENCY);

    while($order_row = $result->fetch_array()) {
        $order_id = $order_row['id'];
        $datetime = $order_row['datetime'];
        $user_id = $order_row['user_id'];

        // Get the name of the user
        $name = 'Inconnu.e';
        $name_query_result = $mysqli->query('SELECT username FROM users WHERE id=' . $user_id);
        if(!$name_query_result) {
            echo '<small class="text-danger">Error : '. $mysqli->error .'</small>';
        } else {
            $name = $name_query_result->fetch_array()['username'];
        }

        // Set a time message depending on the interval
        $date_message = '';
        $time_delta = date_diff(new DateTime($datetime), new DateTime(date('Y-m-d H:i:s')), true);

        if($time_delta->d > 1) {
            $date_message = 'Il y a ' . $time_delta->d . ' jours';
        } else if($time_delta->d == 1) {
            $date_message = 'Il y a ' . $time_delta->d . ' jour';
        } else if($time_delta->d == 0 && $time_delta->h == 1) {
            $date_message = 'Il y a ' . $time_delta->h . ' heure'; 
        } else if($time_delta->d == 0 && $time_delta->h > 0) {
            $date_message = 'Il y a ' . $time_delta->h . ' heures'; 
        } else if($time_delta->h == 0 && $time_delta->i == 1) {
            $date_message = 'Il y a ' . $time_delta->i . ' minute';
        } else if($time_delta->h == 0 && $time_delta->i == 1) {
            $date_message = 'Il y a ' . $time_delta->i . ' minute';
        } else if($time_delta->h == 0 && $time_delta->i != 0) {
            $date_message = 'Il y a ' . $time_delta->i . ' minutes';
        } else if($time_delta->i == 0) {
            $date_message = 'Il y a quelques secondes';
        }

        

        // Get all products form this order
        $req = 'SELECT name, price, bdlc_price, quantity FROM item_orders o INNER JOIN products p ON o.product_id = p.id WHERE order_id=' . $order_id;
        $item_order_query_result = $mysqli->query($req);
        if(!$item_order_query_result) {
            echo '<small class="text-danger">Error : '. $mysqli->error .'</small>';
            continue;
        }

        $product_rows = [];
        $total_price = 0;

        while($product_row = $item_order_query_result->fetch_array())
        {
            // Calculate the total price
            $actualPrice = ($_SESSION['bdlc_member']) ? $product_row['bdlc_price'] : $product_row['price'];
            $total = $actualPrice * $product_row['quantity'];
            $total_price += $total;

            // Store it in an array
            $product_rows[] = array(
                'name' => $product_row['name'],
                'price' => $actualPrice,
                'total' => $total,
                'quantity' => $product_row['quantity']
            );
        }

        // Display the head of the order
?>

                <div class="card">
                    <div class="card-header" id="heading<?php echo $order_id; ?>">
                        <div class="sortable" data-toggle="collapse" data-target="#collapse<?php echo $order_id; ?>">
                            <p class="mb-0">
                                <span class="badge badge-secondary mr-1">#<?php echo $order_id; ?></span>
                                par <?php echo $name; ?> : <b><?php echo $fmt->formatCurrency($total_price, "EUR"); ?></b>
                            </p>
                            <small class=""><?php echo $date_message; ?></small>
                        </div>
                    </div>
                    <div id="collapse<?php echo $order_id; ?>" class="collapse pl-4 pr-4" aria-labelledby="heading<?php echo $order_id; ?>" data-parent="#accordion">
                        <table class="table table-sm">
                            <tr>
                                <th>Nom</th>
                                <th>Quantité</th>
                                <th>Prix à l'unité</th>
                                <th>Prix total</th>
                            </tr>
<?php        
        foreach ($product_rows as $row) {
        // Add each products
?>
                            <tr>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['quantity']; ?></td>
                                <td><?php echo $fmt->formatCurrency($row['price'], "EUR"); ?></td>
                                <td><?php echo $fmt->formatCurrency($row['total'], "EUR"); ?></td>
                            </tr>
<?php
        }
?>
                        </table>
                    </div>
                </div>
<?php
    }
?>
            </div>                  
        </div>
    </main>
</body>
</html>