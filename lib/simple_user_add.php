<?php

require_once('connect.php');
require_once('util.php');

if(isset($_POST['student_number'], $_POST['username'])) {

    $student_number = formatStudentNumber($_POST["student_number"]);
    $isMember = (isset($_POST['bdlc_member'])) ? '1' : '0';

    $mysqli = connectToDatabase();
    insert($mysqli, 'users', array(
        array('key' => 'student_number', 'value' => $student_number),
        array('key' => 'password', 'value' => getRandomString()),
        array('key' => 'username', 'value' => $_POST['username']),
        array('key' => 'bdlc_member', 'value' => $isMember),
        array('key' => 'auth_level', 'value' => '0'),
        array('key' => 'credit', 'value' => '0'),
        array('key' => 'activated', 'value' => '0')
    ));
    
    header('Location: ../add_user.php?add_status=success');
} else {
    header('Location: ../add_user.php?add_status=error');
}

?>