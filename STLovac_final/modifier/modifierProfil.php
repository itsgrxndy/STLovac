<?php
/*
ob_start --> header sur 000webhost
inseré le header contenant la connexion a la base de donnée
verification qu'un compte est déja lancer 
mise a jour de last_activity
*/
ob_start();

require_once('../includes/header.php');
if(isset($_SESSION['user_id']) AND !empty($_SESSION['user_id'])) {
	$query = "
	UPDATE login_details 
	SET last_activity = now() 
	WHERE user_email = '".$_SESSION['user_email']."'
	";

	$statement = $db->prepare($query);

	$statement->execute();
	?>
	<!DOCTYPE html>
	<html>
	<head>
		<title>Profil | St-Marc</title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="../style/modife.css">
	</head>
	<body style="font-family: tahoma; background-color: #d0d8e4;">
		<?php

		$user_id=$_SESSION['user_id'];
		$select = $db->query("SELECT * FROM membres WHERE id='$user_id'");




		while($s = $select->fetch(PDO::FETCH_OBJ)){
			?>
<!--
barre du haut 
-->
<br>
<div id="blue_bar">
	<div style="width: 800px; margin: auto; font-size: 30px;">
		StLovac &ensp;					
		<a href="profile.php"><img src="img_profil/profile/<?php echo "$s->email";?>.jpg" title="Profile" style="width: 50px; float: right; border-radius: 50%; "></a> 	
		<a href="actu.php"><img src="stmarc.png" title="Actualité" style="width: 50px; float: right; border-radius: 50%;"></a>
	</div>
</div>
<!--
barre profil
-->
<div style="width: 800px; margin: auto; background-color: black; min-height: 400px;">
	<div style="background-color: white; text-align: center; color: #405d9b">
		<img src="../img_profil/fond/<?php echo "$s->email";?>.jpg" style="width: 100%; height: 300px;">
		<img src="../img_profil/profile/<?php echo "$s->email";?>.jpg" id="profile_pic">
		<br>
		<h3><?php echo $s->nom; ?> &nbsp <?php echo $s->prenom; ?></h3>
		<br>
		<nav>
			<a href="../actu.php">Actualité</a>
			<a href="../membres.php">Membres</a>
			<a href="../chat/index.php">Messages</a>
			<a href="../public.php">Crush</a>
			<a href="../profile.php">Profil</a>
			<a href="../modifier.php">Modifier</a>
		</nav>		
	</div>
</div>
<?php
}
?>

<br><br>
</body>
</html>

<?php
$user_id = $_SESSION['user_id'];
$select = $db->prepare("SELECT * FROM membres WHERE id=$user_id");
$select->execute();

$data = $select->fetch(PDO::FETCH_OBJ);


?>
<div id="modifier">
	<!-- formulaire de modification -->
	<form action="" method="post" enctype="multipart/form-data">
		<h3>Snapchat :</h3>
		<input type="text" id="text" value="<?php echo $data->snap; ?>" name="snap"><br>
		<h3>Instagram :</h3>
		<input type="text" id="text" value="<?php echo $data->insta; ?>" name="insta"><br>
		<h3>Classe :</h3>
		<select id="text" name="classe" value="<?php echo $data->classe; ?>">
			<option>Terminale</option>
			<option>Première</option>
			<option>Seconde</option>
		</select>
		<h3>Description :</h3>
		<input type="text" id="text" value="<?php echo $data->description; ?>" name="description"><br><br><br>
		<input type="submit" name="submit" value="Modifier" id="button" >		
	</form>
</div>





<?php
//remplacer les valeur de la table membre par les valeurs rentrer
if(isset($_POST['submit'])){
	$description=$_POST['description'];
	$snap = $_POST['snap'];
	$insta = $_POST['insta'];
	$classe = $_POST['classe'];

	$user_id=$_SESSION['user_id'];

	$update = $db->prepare("UPDATE membres SET description='$description', snap='$snap', insta='$insta', classe='$classe'  WHERE id=$user_id");
	$update->execute();

	header('Location:../modifier.php');
}
}else{
	header("Location:login.php");
}