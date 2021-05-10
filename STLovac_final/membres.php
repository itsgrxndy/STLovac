<?php
/*
ob_start --> header sur 000webhost
inseré le header contenant la connexion a la base de donnée
verification qu'un compte est déja lancer 
mise a jour de last_activity
*/
ob_start();
require_once('includes/header.php');
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
		<title>Membre | STLovac</title>
		<meta charset='utf8mb4'>
		<link rel="stylesheet" type="text/css" href="style/membres.css">
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
<div style="width: 800px; margin: auto; background-color: black; min-height: 300px;">
	<div style="background-color: white; text-align: center; color: #405d9b">
		<img src="img_profil/fond/<?php echo "$s->email";?>.jpg" style="width: 100%; height: 300px;">
		<img src="img_profil/profile/<?php echo "$s->email";?>.jpg" id="profile_pic">
		<br>
		<h3 style="color:#405d9b;"><?php echo $s->nom; ?> &nbsp <?php echo $s->prenom; ?></h3>
		<br>
		<nav>
			<a href="actu.php">Actualité</a>
			<a href="membres.php">Membres</a>
			<a href="chat/index.php">Messages</a>
			<a href="public.php">Crush</a>
			<a href="profile.php">Profil</a>
			<a href="modifier.php">Modifier</a>
		</nav>		
	</div>
</div>

<?php
}
?>
<div id="block">
	<?php

	$user_id = $_SESSION['user_id'];
//recherche personne 
	
	$membre = $db->query('SELECT nomprenom,id,email FROM membres ORDER BY id DESC');
	if(isset($_GET['q']) AND !empty($_GET['q'])) {
		$q = htmlspecialchars($_GET['q']);
		$membre = $db->query('SELECT nomprenom,id,email FROM membres WHERE nomprenom LIKE "%'.$q.'%" ORDER BY id DESC');
		if($membre->rowCount() == 0) {
			$membre = $db->query('SELECT nomprenom, id, email FROM membres WHERE CONCAT(nomprenom) LIKE "%'.$q.'%" ORDER BY id DESC');
		}
	}
	?>
	<center>
		<div style="background-color: white; width: 500px; border-radius: 5px; margin: 5px;text-align: center;font-weight: bold;position: right;filter: drop-shadow(0 0 0.2rem #405d9b);"><center>
			<form method="GET">
				<input type="search" name="q" id="search_box" placeholder="Recherche..." />
				<input type="submit" value="Valider" id="button" /><br>
			</form>
		</center>
	</div></center>

	<?php if($membre->rowCount() > 0) { ?>
		
		<?php while($a = $membre->fetch()) { ?>
			<!-- affiche des personne (sauf sois) -->
			<center>
				<div style="background-color: white; width: 500px; margin: 2px;text-align: center;font-weight: bold;position: right;filter: drop-shadow(0 0 0.2rem #405d9b);"><center><?php
				if($a['id'] != $user_id){?>
					<br><br>
					<a href="membresPage.php?id=<?php echo $a['id']; ?>"><img style="width: 200px; height: 200px; margin: auto; border-radius: 5px; border: 3px  #405d9b solid;" src="img_profil/profile/<?php echo $a['email'];?>.jpg"></a><br><br>
					<a id="link" href="membresPage.php?id=<?php echo $a['id']; ?>"><?= $a['nomprenom'] ?></a><br><br>
					<?php } ?> </center></div></center> 
					
				<?php }  } else { ?>
					Aucun résultat pour: <?= $q ?>...
				<?php } 
				?>
			</div>
		</body>
		</html>
		<?php
	}else{
		header("Location:login.php");
	}
	?>