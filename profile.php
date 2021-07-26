<?php

session_start();

if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] != TRUE) {
	exit('Vous n\'êtes pas connecté !');
}

echo 'Bonjour ' . $_SESSION['username'] . '!';

?>