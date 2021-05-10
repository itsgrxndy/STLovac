<?php
/*
ob_start --> header sur 000webhost
connexion à la base de donnée 
suppresion d'une actualité
*/
ob_start();

$db = new PDO('mysql:host=localhost;dbname=id16129291_stlovac;charset=utf8mb4', 'id16129291_cavolts','6h6h-WBbp(H!021s');
$id = $_GET['id'];		
$delete = $db->prepare("DELETE FROM actu WHERE id=$id");
$delete->execute();


header("Location:actu.php")
?>