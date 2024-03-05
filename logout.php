<?php


session_unset();
session_destroy();

//echo 'Logout successful';
header('location:home.php');
//exit();
?>