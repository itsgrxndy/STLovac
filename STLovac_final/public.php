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
		<meta charset="utf8mb4">
		<link rel="stylesheet" type="text/css" href="style/public.css">
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

//afficher les commentaires anonyme | non anonyme

	$commentaires = $db->prepare('SELECT * FROM commentaires ORDER BY id DESC');
	$commentaires->execute();
	?> <h3 style="color: #405d9b;">commentaire public</h3><br>
	<div id="commentaire">
		<table style="width: 700px;">
			<tr style="width: 700px; ">
				<td style="width: 100px; text-align: left ;"><h3 style="color: #405d9b;">Nom</h3></td>
				<td style="width: 520px; text-align: left ;"><h3 style="color: #405d9b;">commentaire public</h3></td>
				<td style="width: 80px;"><h3 style="color: #405d9b;">Répondre</h3></td>
			</tr>		
		</table>
		<br />
	</div>
	<?php
	while($c = $commentaires->fetch()) { 

		if($c['anonyme'] == 0){
			?> 
			<div id="commentaire">
				<table style="width: 700px;">
					<tr style="width: 700px; ">
						<td style="width: 100px; text-align: left ;"><b><?= $c['pseudo'] ?> :</b></td>
						<td style="width: 520px; text-align: left ;"><?= $c['commentaire'] ?></td>
						<td style="width: 80px;"><a id="link" href="reponse.php?id=<?php echo $c['id'];?>">répondre</a></td>
					</tr>		
				</table>
				<br />
			</div>
		<?php }

		elseif($c['anonyme'] == 1){
			?>
			<div id="commentaire">
				<table style="width: 700px;">
					<tr style="width: 700px; ">
						<td style="width: 100px; text-align: left ;"><b>Anonyme :</b></td>
						<td style="width: 520px; text-align: left ;"><?= $c['commentaire'] ?></td>
						<td style="width: 80px;"><a id="link" href="reponse.php?id=<?php echo $c['id'];?>">répondre</a></td>
					</tr>	

				</table>
				<br />	
			</div>
			<?php
		}
	} 
	?>
</div>
</body>
</html>
<?php
}else{
	header("Location:login.php");
}
?>