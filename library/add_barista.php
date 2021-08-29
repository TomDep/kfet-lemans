<?php
    
    include($_SERVER['DOCUMENT_ROOT'] . '/kfet/library/connect.php');

    // Test if all data was submitted
    if(!isset($_POST['username']) || empty($_POST['username'])) {
        // Could not get the data that should have been sent.
        exit('Please fill all the required fields!');
    }

    $imgName = 'undefined.jpg';

    // If there is no photo, let it to blank
    if(isset($_FILES['barista_photo']) && $_FILES['barista_photo']['error'] == 0) {
        // Upload the file to the server 
        $dir = $_SERVER['DOCUMENT_ROOT'] . '/kfet/res/images/baristas/';

        $imageFileType = strtolower(pathinfo($_FILES['barista_photo']['name'] ,PATHINFO_EXTENSION));
        $path = $dir . str_replace(' ', '_', $_POST['username']) . '.' . $imageFileType;
        $imgName = str_replace(' ', '_', $_POST['username']) . '.' . $imageFileType;
        
        // Move the file into the server storage
        if(!move_uploaded_file($_FILES['barista_photo']['tmp_name'], $path)) {
            // Error while uploading the file
            exit('Couldn\'t upload the file to the server !');
        }
    }
    
    // Connect to the database
    $connection = connectToDatabase();
    if($connection == FALSE) {
        echo '<p>Il y a eu une erreur ...</p>';
        exit();
    }
    
    // Check if there is already a barista with this name
    $req = 'SELECT id FROM baristas WHERE user_id = (SELECT id FROM users WHERE username = ?)';

    if($stmt = $connection->prepare($req)) {
        $stmt->bind_param('s', $_POST['username']);
        $stmt->execute();
        $stmt->store_result();

        // Store the result so we can check if the barista exists in the database.
        if($stmt->num_rows > 0) {
            // Barista already exists
            $stmt->close();

            exit('The barista is already added');
        } else {

            $req = 'INSERT INTO baristas (user_id, class, photo) VALUES ((SELECT id FROM users WHERE username = ?), ?, ?)';
            if($stmt = $connection->prepare($req)) {
                $stmt->bind_param('sss', $_POST['username'], $_POST['class'], $imgName);
                $stmt->execute();

                echo htmlspecialchars($_POST['username']) . ' a bien été ajouté';

                // Change the user authorisation level
                $req = 'UPDATE users SET auth_level = 1 WHERE username = ?';
                if($stmt = $connection->prepare($req)) {
                    $stmt->bind_param('s', $_POST['username']);
                    $stmt->execute();
                }

            } else {
                echo 'Error : ' . $connection->error;
            }
        }
    } else {
        echo 'Error : ' . $connection->error;
    }



?>