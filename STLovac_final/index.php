<?php
/*
ob_start --> header sur 000webhost
redirection vers login
(page index crée car sur un heberger la première page est un ficher index.php ou index.html)
*/
ob_start();

header("Location:login.php");
?>
