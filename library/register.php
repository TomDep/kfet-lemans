<?php
session_start();

require_once('connect.php');

// Maybe some sort of rooting could be used to avoid such things
// Root to the index if the user is not authorized
/*
if(isset($_SESSION['auth_level']) && $_SESSION['auth_level'] > 0) {
	header('Location: index.php');
}
*/

// Check if data was submited for every field
if(!isset($_POST['student_number'], $_POST['username'], $_POST['auth_level'])) {
	// Could not get the data that should have been sent.
	exit('Please fill all the needed fields!');
}

// Make sure the submetted registerations are not empty
if(empty($_POST['student_number']) || empty($_POST['username'])) {
	// One or more values are empty
	exit('Please fill all the needed fields!');
}

// Get the correct value for the checkbox
$bdlc_member = (isset($_POST['bdlc_member'])) ? TRUE : FALSE;

// Connect to the database
$connection = connectToDatabase();
if($connection == FALSE) {
	exit();
}

// Check if there is already an account for this student number
$req = 'SELECT id FROM users WHERE student_number = ?';
if($stmt = $connection->prepare($req)) {
	$stmt->bind_param('i', $_POST['student_number']);
	$stmt->execute();
	$stmt->store_result();

	// Store the result so we can check if the account exists in the database.
	if($stmt->num_rows > 0) {
		// User already exists
		$stmt->close();

		exit('The user already exists');
	}
}

// Prepare our SQL, preparing the SQL statement will prevent SQL injection.
$req = 'INSERT INTO users (student_number, username, bdlc_member, auth_level) VALUES (?, ?, ?, ?)';
if ($stmt = $connection->prepare($req)) {

	// Bind parameters
	$stmt->bind_param('isii', $_POST['student_number'], $_POST['username'], $bdlc_member, $_POST['auth_level']);
	if($stmt->execute() == FALSE) {
		exit('Could not INSERT a new user to the database : ' . $connection->error);
	}

	echo $_POST['username'] . ' a bien été ajouté à la base de donnée !';
	$stmt->close();
	$connection->close();
}

?>