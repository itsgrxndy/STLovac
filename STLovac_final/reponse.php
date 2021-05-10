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
		<title>Réponse | STLovac</title>
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

	if(isset($_GET['id']) AND !empty($_GET['id'])) {
		$getid = (int) $_GET['id'];
		$user_id=$_SESSION['user_id'];

		$commentaires = $db->prepare('SELECT * FROM commentaires WHERE id = ?');
		$commentaires->execute(array($getid));
		while($c = $commentaires->fetch()) { 

			$membres = $db->prepare('SELECT * FROM membres WHERE id = ?');
			$membres->execute(array($user_id));
			while ($m = $membres->fetch()) {
/*
commentaire public | non anonyme
*/
if($c['anonyme'] == 0){
	?> 
	<div id="commentaire">
		<table style="width: 700px;">
			<tr style="width: 700px; ">
				<td style="width: 700px; text-align: left ;"><b>Message de <?= $c['pseudo'] ?> :</b></td>
			</tr>
			<tr style="width: 700px;">
				<td style="width: 700px; text-align: left ;"><?= $c['commentaire'] ?></td>
			</tr>
		</table>
		<br>
		<!-- formulaire reponse -->
		<table style="width: 700px; ">
			<tr style="width: 700px; ">
				<td style="width: 100px; text-align: left ; "><?= $m['nomprenom'] ?></td>
				<td style="width: 520px; text-align: left ;"><form method="post" action=""><input type="text" name="reponse" id="text" placeholder="Votre réponse"></td>
					<td style="width: 80px; "><input type="submit" name="submit" value="Envoyer"></form></td>
				</tr>	
			</table>
			<br />
		</div>
	<?php }
/*
commentaire public | anonyme
*/
elseif($c['anonyme'] == 1){
	?>
	<div id="commentaire">
		<table style="width: 700px;">
			<tr style="width: 700px; ">
				<td style="width: 700px; text-align: left ;"><b>Message anonyme :</b></td>
			</tr>
			<tr style="width: 700px;">
				<td style="width: 700px; text-align: left ;"><?= $c['commentaire'] ?></td>
			</tr>
		</table>
		<br>
		<!-- formulaire reponse -->
		<table style="width: 700px; ">
			<tr style="width: 700px; ">
				<td style="width: 100px; text-align: left ; "><?= $m['nomprenom'] ?></td>
				<td style="width: 520px; text-align: left ;"><form method="post" action=""><input type="text" name="reponse" id="text" placeholder="Votre réponse"></td>
					<td style="width: 80px; "><input type="submit" name="submit" value="Envoyer"></form></td>
				</tr>	
			</table>
			<br />
		</div>
		<?php
	}
	?>
	<div id="commentaire1">
		<?php
//reponse pour ce commentaire
		$reponse = $db->prepare('SELECT * FROM reponse WHERE id_comm = ?');
		$reponse->execute(array($getid));
		while ($r = $reponse->fetch()) {
			$info = $db->prepare('SELECT * FROM membres WHERE id = ?');
			$info->execute(array($r['id_membre']));
			while ($i = $info->fetch()) {
				?>
				<table style="width: 620px; border-bottom: 1px ridge #405d9b; ">
					<tr style="width: 620px;">
						<td style="width: 200px; text-align: left ;"><b><?= $i['nomprenom'] ?>:</b></td>
						<td style="width: 420px; text-align: left ;"><?= $r['reponse'] ?></td>
					</tr>	
				</table>
				<br/>	
				<?php
			}}	
			?>
		</div>
		<?php
	}
}
} 
?>
</div>
</body>
</html>


<?php
//insertion des reponses dans la table reponse
if (isset($_POST['submit'])){
	$membres = $db->prepare('SELECT * FROM membres WHERE id = ?');
	$membres->execute(array($user_id));
	$m = $membres->fetch();
	$reponse=$_POST['reponse'];
	$nomprenom = $m['nomprenom'];

	if($reponse&$nomprenom){
		$id_comm = (int) $_GET['id'];
		$user_id=$_SESSION['user_id'];
		$commentaires = $db->prepare('SELECT * FROM commentaires WHERE id = ?');
		$commentaires->execute(array($id_comm));

		$c = $commentaires->fetch();
		$id_expediteur = $c['id_membre'];		
		$db->query("INSERT INTO reponse (id_comm,id_expediteur,id_membre,reponse) VALUES('$id_comm','$id_expediteur','$user_id','$reponse')");
		header("Location:reponse.php?id=$id_comm");

	}else{
		echo "Veillez remplir tous les champs";
	}
}
}else{
	header("Location:login.php");
}
?>