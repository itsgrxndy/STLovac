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
		<title>Profil | STLovac</title>
		<meta charset='utf8mb4'>
		<link rel="stylesheet" type="text/css" href="style/profile.css">
	</head>
	<body>

		<?php
		$user_id=$_SESSION['user_id'];
		$select = $db->query("SELECT * FROM membres WHERE id='$user_id'");

		while($s = $select->fetch(PDO::FETCH_OBJ)){
			?>
<!--
barre du haut 
-->
<br>
<form method="GET">
	<div id="blue_bar">
		<div style="width: 800px; margin: auto; font-size: 40px;">

			StLovac &ensp;					
			<a href="profile.php"><img src="img_profil/profile/<?php echo "$s->email";?>.jpg" title="Profile" style="width: 50px; float: right; border-radius: 50%; "></a> 	
			<a href="actu.php"><img src="stmarc.png" title="Actualité" style="width: 50px; float: right; border-radius: 50%;"></a>
		</div>
	</div>
</form>
<!--
barre profil 
-->
<div style="width: 800px; margin: auto; background-color: black; min-height: 300px;">
	<div style="background-color: white; text-align: center; color: #405d9b">
		<img src="img_profil/fond/<?php echo "$s->email";?>.jpg" style="width: 100%; height: 300px;">
		<img src="img_profil/profile/<?php echo "$s->email";?>.jpg" id="profile_pic">
		<br>
		<h3><?php echo $s->nom; ?> &nbsp <?php echo $s->prenom; ?></h3>
		<h5><?php echo $s->description; ?></h5>
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
	<center>
		<table style="width: 700px;">
			<tr style="width: 450px;">
				<td style="width: 450px;">
					<div id="fav">
						<!-- block favoris (photo, nom des personnes ajouter en favoris) -->
						<center><h4>Favoris</h4></center>
						<?php
						$msg = $db->prepare('SELECT * FROM favoris WHERE id_membre = ? ');
						$msg->execute(array($_SESSION['user_id']));

						while($m = $msg->fetch()) {
							$personne = $m['id_destinataire'];

							$sel = $db->prepare('SELECT * FROM membres WHERE id = ?');
							$sel->execute(array($personne));
							while($w = $sel->fetch()){
								?>
								<table style="width: 450px;">
									<tr style="width: 450px;">
										<td style="width: 75px;"><a href="membresPage.php?id=<?php echo $w['id']; ?>"><img style="width: 75px; height: 75px; margin: auto; border-radius: 5px; border: 3px  #405d9b solid;" src="img_profil/profile/<?php echo $w['email'];?>.jpg"></a></td>
										<td style="width: 375px;"><a id="link2" href="membresPage.php?id=<?php echo $w['id']; ?>"><h3><?= $w['nomprenom'] ?></h3></a></td>
									</tr>
								</table>

								<?php
							}
						}
						?>
					</div>
				</td>
				<td style="width: 50px;"></td>
				<td style="width: 200px;">
					<div id="resaux">
						<!-- block resau (classe, snap, insta, et photo de la session) -->
						<?php 
						$select = $db->query("SELECT * FROM membres WHERE id='$user_id'");
						$s = $select->fetch(PDO::FETCH_OBJ);
						?>
						<center><h3 style="color: #405d9b; font-size: 12px;">Classe : &ensp; <?php echo $s->classe; ?></h3></center><br>

						<table style="margin: auto; padding: auto;">
							<tr style="margin: auto; padding: auto; ">
								<td style="margin: auto; padding: auto; width: 100px;"><center><a href="https://instagram.com/<?php echo $s->insta; ?>"><img src="insta.png" style="width: 75px; height: 75px;"></a></center></td>
								<td style="margin: auto; padding: auto; width: 100px;"><center><a href="https://www.snapchat.com/add/<?php echo $s->snap; ?>"><img src="snap.png" style="width: 75px; height: 75px;"></a></center></td>
							</tr>
						</table>
						<br><br>
						<?php
						$id = $user_id;
						$likes = $db->prepare('SELECT id FROM likes WHERE id_destinataire = ?');
						$likes->execute(array($id));
						$likes = $likes->rowCount();
						$dislikes = $db->prepare('SELECT id FROM dislikes WHERE id_destinataire = ?');
						$dislikes->execute(array($id));
						$dislikes = $dislikes->rowCount();

						?>
						<table style="margin: auto; padding: auto;">
							<tr style="margin: auto; padding: auto; ">
								<td style="margin: auto; padding: auto; width: 100px;"><center><img style="width: 75px; height: 75px; position: center;" src="like.png"><br><h4 style="color: #405d9b; font-size: 12px; position: center;"><?= $likes ?></h4></center></td>
								<td style="margin: auto; padding: auto; width: 100px;"><center><img style="width: 75px; height: 75px; position: center;" src="dislike.png"><br><h4 style="color: #405d9b; font-size: 12px; position: center;"><?= $dislikes ?></h4></center></td>
							</tr>
						</table>
						<table style="margin: auto; padding: auto;">
							<tr style="margin: auto; padding: auto; ">
								<td><img src="img_profil/profile/<?php echo "$s->email";?>.jpg" title="Profile" style="width: 175px; height: 175px; border-radius: 4px; float: right; "></td>
							</tr>
						</table>

					</div>
				</td>
			</tr>
		</table>
	</center>
	<center>
		<div id="comm">
			<!-- block commentaire (formulaire avec option d'anonymat) -->
			<center>
				<meta charset="utf-8" />
				<?php
				$Sid = $_SESSION['user_id'];
				$membres = $db->prepare('SELECT * FROM membres WHERE id = ?');
				$membres->execute(array($Sid));
				$membres = $membres->fetch();
				if(isset($_POST['submit_commentaire'])) {
					if(isset($_POST['commentaire']) AND !empty($_POST['commentaire'])) {
						$pseudo = $membres['nomprenom'];
						$commentaire = htmlspecialchars($_POST['commentaire']);
						$anonyme = $_POST['anonyme'];
						$ins = $db->prepare('INSERT INTO commentaires (id_membre, pseudo, commentaire, anonyme) VALUES (?,?,?,?)');
						$ins->execute(array($Sid,$pseudo,$commentaire,$anonyme));
						$c_msg = "<span style='color:green'>Votre commentaire a bien été posté</span>";
					} else {
						$c_msg = "Erreur: Tous les champs doivent être complétés";
					}
				}
				$commentaires = $db->prepare('SELECT * FROM commentaires WHERE id_membre = ? ORDER BY id DESC');
				$commentaires->execute(array($Sid));
				?>
				<h4>Commentaires:</h4>
				<form method="POST">
					<input type="radio" name="anonyme" value="1">anonyme &ensp;
					<input type="radio" name="anonyme" value="0"><?= $membres['nomprenom'] ?><br><br>
					<textarea style="height: 300px;width: 400px;border-radius: 4px;border:solid 1px #ccc;padding: 4px;font-size : 14px;" name="commentaire" type="text" placeholder="Votre commentaire..."></textarea><br><br>
					<input type="submit" id="button" style="width: 300px;" value="Poster mon commentaire" name="submit_commentaire" />
				</form>
				<?php if(isset($c_msg)) { echo $c_msg; } ?>
				<br /><br />
			</center>
		</div>
	</center>
	<center>
		<div id="rep">
			<!-- block reponse (comprend tout les commentaire que la personne a envoyer) -->
			<center>
				<?php
				if(isset($_SESSION['user_id']) AND !empty($_SESSION['user_id'])) {
					$Sid = $_SESSION['user_id'];
					$comm = $db->prepare('SELECT * FROM commentaires WHERE id_membre = ?');
					$comm->execute(array($Sid));
					?><h4>Réponses:</h4><?php
					while($c = $comm->fetch()){ ?>
						<center>
							<div style="background-color: white; width: 600px; margin: 5px;text-align: center;font-weight: bold;position: center;filter: drop-shadow(0 0 0.2rem #405d9b);">
								<center>
									<a style="text-decoration: none; color: black;" href="reponse.php?id=<?php echo $c['id'];?>"><?= $c['commentaire'] ?></a><br>
								</center>
							</div>
						</center>
						<?php
					}
				}
				?>
				<br /><br />
			</center>
		</div>
	</center>
	<br><br><a id="link" href="deconnexion.php">Se deconnecter</a>
</div>
</body>
</html>		
<?php
}else{
	header("Location:login.php");
}
