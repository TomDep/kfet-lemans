<?php
session_start();

require_once('connect.php');

// Check if the data from the login form was submitted, isset() will check if the data exists.
if ( !isset($_POST['student_number'], $_POST['password']) ) {
	// Could not get the data that should have been sent.
	exit('Please fill both the student_number and password fields!');
}

// Connect to the database
$connection = connect_to_database();
if($connection == FALSE) {
	exit();
}

// Prepare our SQL, preparing the SQL statement will prevent SQL injection.
if ($stmt = $connection->prepare('SELECT id, password, username, auth_level FROM users WHERE student_number = ?')) {

	// Bind parameters (s = string, i = int, b = blob, etc), in our case the student number is an int so we use "i"
	$stmt->bind_param('s', $_POST['student_number']);
	$stmt->execute();
	// Store the result so we can check if the account exists in the database.
	$stmt->store_result();

	if ($stmt->num_rows > 0) {
		$stmt->bind_result($id, $password, $username, $auth_level);
		$stmt->fetch();
		// Account exists, now we verify the password.
		// Note: remember to use password_hash in your registration file to store the hashed passwords.
		if (password_verify($_POST['password'], $password)) {
			// Verification success! User has logged-in!
			// Create sessions, so we know the user is logged in, they basically act like cookies but remember the data on the server.
			session_regenerate_id();
			$_SESSION['logged_in'] = TRUE;
			$_SESSION['username'] = $username;
			$_SESSION['auth_level'] = $auth_level;
			$_SESSION['id'] = $id;

			echo 'Welcome ' . $_SESSION['username'] . '!';
			echo '<a href="index.php">Retour à l\'acceuil</a>';
		} else {
			// Incorrect password
			echo 'Incorrect username and/or password!';
		}
	} else {
		// Incorrect username
		echo 'Incorrect username and/or password!';
	}

	$stmt->close();
}
?>