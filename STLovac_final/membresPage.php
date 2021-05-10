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
		<link rel="stylesheet" type="text/css" href="style/membresPage.css">
	</head>
	<body style="font-family: tahoma; background-color: #d0d8e4;">

		<?php
		$id = intval($_GET['id']);
		$user_id = $_SESSION['user_id'];
//selction info personne rechercher	
		$select = $db->prepare("SELECT * FROM membres WHERE id = $id");
		$select->execute();

		$s = $select->fetch(PDO::FETCH_OBJ);
//selection information de la session
		$selectP = $db->prepare("SELECT * FROM membres WHERE id = $user_id");
		$selectP->execute();

		$p = $selectP->fetch(PDO::FETCH_OBJ);

		?>
<!--
barre du haut 
-->
<div id="blue_bar">
	<div style="width: 800px; margin: auto; font-size: 30px;">
		StLovac &ensp;					
		<a href="profile.php"><img src="img_profil/profile/<?php echo "$p->email";?>.jpg" title="Profile" style="width: 50px; float: right; border-radius: 50%; "></a> 	
		<a href="actu.php"><img src="stmarc.png" title="Actualité" style="width: 50px; float: right; border-radius: 50%;"></a>
	</div>
</div>
<!--
barre profil personne rechercher 
-->
<div style="width: 800px; margin: auto; background-color: black; min-height: 300px;">
	<div style="background-color: white; text-align: center; color: #405d9b">
		<img src="img_profil/fond/<?php echo "$s->email";?>.jpg" style="width: 100%; height: 300px;">
		<img src="img_profil/profile/<?php echo "$s->email";?>.jpg" id="profile_pic">
		<br>
		<h3 style="color:#405d9b;"><?php echo $s->nom; ?> &nbsp <?php echo $s->prenom; ?></h3>
		
		<h5 style="color:#405d9b;"><?php echo $s->description; ?></h5>
		
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


<div id="block">
	<center>
		<table style="width: 700px;">
			<tr style="width: 700px;">
				<td>
					<center>
						<div style="background-color: white; width: 500px; border-radius: 5px; margin: 5px;text-align: center;font-weight: bold;position: right;filter: drop-shadow(0 0 0.2rem #405d9b);"><center>
							<br><br>
							<?php
//bouton pour contacter ou ajouter en favoris la personne
							$select = $db->prepare("SELECT * FROM membres WHERE id = $id");
							$select->execute();

							$s = $select->fetch(PDO::FETCH_OBJ);
							?>
							<a id="link" href="chat/index.php?id=<?php echo $s->id; ?>"> Envoyer un message à <?php echo $s->nomprenom; ?></a><br><br>

							<a id="link" href="php/actionf.php?id=<?= $id ?>">Ajouter <?php echo $s->nomprenom; ?> comme favori</a><br><br>

							<?php
							$get_id1 = htmlspecialchars($_GET['id']);
							
							$fav = $db->prepare('SELECT id_destinataire FROM favoris WHERE id_membre = ? ');
							$fav->execute(array($_SESSION['user_id']));
							while($m = $fav->fetch()) {
								if($get_id1 == $m['id_destinataire']){
									?>

									<h4 style="color:#405d9b;"><?= $s->nomprenom; ?> est dans vos favoris &ensp;<img src="fav.png" style="width: 20px; height: 20px;"></h4>
									<?php
								}
							}
							?>
						</center></div></center>
					</td>
					<td>
						<center>
							<div style="background-color: white; width: 200px; border-radius: 5px; margin: 5px;text-align: center;font-weight: bold;position: right;filter: drop-shadow(0 0 0.2rem #405d9b);"><center>
								<table style="">
									<tr style=" ">
										<td style="margin: auto; padding: auto; width: 100px;"><center><a href="https://instagram.com/<?php echo $s->insta; ?>"><img src="insta.png" style="width: 75px; height: 75px;"></a></center></td>
										<td style="margin: auto; padding: auto; width: 100px;"><center><a href="https://www.snapchat.com/add/<?php echo $s->snap; ?>"><img src="snap.png" style="width: 75px; height: 75px;"></a></center></td>
									</tr>
								</table>
								<br><br>
								<?php
//systeme de like et dislike en cliquant sur une image 
								if(isset($_GET['id']) AND !empty($_GET['id'])) {
									$get_id = htmlspecialchars($_GET['id']);
									$destinataire = $db->prepare('SELECT * FROM membres WHERE id = ?');
									$destinataire->execute(array($get_id));
									if($destinataire->rowCount() == 1) {
										$destinataire = $destinataire->fetch();
										$id = $destinataire['id'];
										$nom = $destinataire['nom'];
										$prenom = $destinataire['prenom'];
										$likes = $db->prepare('SELECT id FROM likes WHERE id_destinataire = ?');
										$likes->execute(array($id));
										$likes = $likes->rowCount();
										$dislikes = $db->prepare('SELECT id FROM dislikes WHERE id_destinataire = ?');
										$dislikes->execute(array($id));
										$dislikes = $dislikes->rowCount();
									} else {
										die('Cette personne n\'existe pas !');
									}
								} else {
									die('Erreur');
								}
								?>
						<table style="">
							<tr style=" ">
								<td style="margin: auto; padding: auto; width: 100px;"><center><a href="php/action.php?t=1&id=<?= $id ?>"><img style="width: 75px; height: 75px; position: center;" src="like.png"></a><br><h4 style="color: #405d9b; font-size: 12px; position: center;"><?= $likes ?></h4></center></td>
								<td style="margin: auto; padding: auto; width: 100px;"><center><a href="php/action.php?t=2&id=<?= $id ?>"><img style="width: 75px; height: 75px; position: center;" src="dislike.png"></a><br><h4 style="color: #405d9b; font-size: 12px; position: center;"><?= $dislikes ?></h4></center></td>
							</tr>
						</table>
					</center></div></center>
				</td>
			</tr>
		</table>
		<center>
			<div style="background-color: white; width: 310px; border-radius: 5px; margin: 5px;text-align: center;font-weight: bold;position: right;filter: drop-shadow(0 0 0.2rem #405d9b);"><center><?php
			$id = intval($_GET['id']);
			$user_id = $_SESSION['user_id'];		
			$select = $db->prepare("SELECT * FROM membres WHERE id = $id");
			$select->execute();

			$s = $select->fetch(PDO::FETCH_OBJ);?>
			<img style="width: 300px;height: 300px;border-radius: 5px; margin: 5px;" src="img_profil/profile/<?php echo "$s->email";?>.jpg">
		</center></div></center>
		
	</body>
	</html>
	<?php
}else{
	header("Location:login.php");
}
?>