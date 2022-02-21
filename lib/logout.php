<?php

setcookie("kfet-login", "", time() - 3600, '/', '', false, false);
setcookie("kfet-password", "", time() - 3600, '/', '', false, false);

session_start();
session_destroy();

// Redirect to index
header('Location: ../login.php');

?>