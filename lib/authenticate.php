<?php
session_start();

require_once('connect.php');

// Check if the data from the login form was submitted, isset() will check if the data exists.
if ( !isset($_POST['student_number'], $_POST['password']) ) {
	// Could not get the data that should have been sent.
	exit('Please fill both the student_number and password fields!');
}

// Connect to the database
$connection = connectToDatabase();
if($connection == FALSE) {
	exit();
}

require_once "util.php";
$student_number = formatStudentNumber($_POST["student_number"]);

// Prepare our SQL, preparing the SQL statement will prevent SQL injection.
$req = 'SELECT id, password, username, bdlc_member, auth_level, credit FROM users WHERE student_number = ?';
if ($stmt = $connection->prepare($req)) {

	// Bind parameters (s = string, i = int, b = blob, etc), in our case the student number is an int so we use "i"
	$stmt->bind_param('s', $student_number);
	$stmt->execute();
	// Store the result so we can check if the account exists in the database.
	$stmt->store_result();

	if ($stmt->num_rows > 0) {
		$stmt->bind_result($id, $password, $username, $bdlc_member, $auth_level, $credit);
		$stmt->fetch();
		// Account exists, now we verify the password.
		// Note: remember to use password_hash in your registration file to store the hashed passwords.
		if (password_verify($_POST['password'], $password)) {
			// Verification success! User has logged-in!
			// Create sessions, so we know the user is logged in, they basically act like cookies but remember the data on the server.
			session_regenerate_id();
			$_SESSION['logged_in'] = TRUE;
			$_SESSION['username'] = $username;
			$_SESSION['bdlc_member'] = $bdlc_member;
			$_SESSION['auth_level'] = $auth_level;
			$_SESSION['id'] = $id;
			$_SESSION['credit'] = $credit;

			header('Location: ../index.php');
			exit();
		}
	}

	// Incorrect password or student number
	header('Location: ../login.php?login_status=wrong');
	exit();
}

// There has been an error
header('Location: ../login.php?login_status=error');
?>