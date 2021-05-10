<?php
/*
ouverture de la session 
connexion à la base de donnée 
*/
session_start();

try
{
	$db = new PDO('mysql:host=localhost;dbname=id16129291_stlovac;charset=utf8mb4', 'id16129291_cavolts','6h6h-WBbp(H!021s');
	$db->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
	$db->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
	
}
catch(Exception $e){
	echo "une erreur est survenue";
	die();
}

?>