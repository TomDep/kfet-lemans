<?php

function connect_to_database() {
	// Todo : load these informations from a txt file so that we can publish the code of this file
	// Connection info.
	$DATABASE_HOST = 'localhost';
	$DATABASE_USER = 'root';
	$DATABASE_PASS = '';
	$DATABASE_NAME = 'kfet';

	// Try and connect using the info above.
	$connection = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
	if ( mysqli_connect_errno() ) {
		// If there is an error with the connection, stop the script and display the error.
		echo 'Failed to connect to MySQL: ' . mysqli_connect_error();
	}

	$connection->set_charset('utf8_general_ci');

	return $connection;
}

?>