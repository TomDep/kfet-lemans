<?php 

session_start();
session_destroy();

// Redirect to index
header('Location: ../index.php');

?>