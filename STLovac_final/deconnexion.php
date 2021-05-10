<?php
/*
ob_start --> header sur 000webhost
destruction de la session 
*/
ob_start();

session_start();
session_unset();
session_destroy();

header('Location:login.php');

?>