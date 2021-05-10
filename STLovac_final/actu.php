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
		<title>Actualité | STLovac</title>
		<meta charset='utf8mb4'>
		<link rel="stylesheet" type="text/css" href="style/actu.css">
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
//verification de l'id de session (car si id = 1 fontion ajout et supression actu)
//afficher toute les actualité
	if($_SESSION['user_id']== 1){
		?> <a id="link" href="actuAjout.php">Ajouter une actualité</a><br><br> <?php


		$user_id = $_SESSION['user_id'];

		
		$select = $db->prepare("SELECT * FROM actu ");
		$select->execute();

		while ($s=$select->fetch(PDO::FETCH_OBJ)) {
			$lenght = 500;
			$description = $s->description;
			
			
			?>
			<center>
				<div style="background-color: white; width: 500px; margin: 5px;text-align: center;font-weight: bold;position: right;filter: drop-shadow(0 0 0.2rem #405d9b);"><center>
					<br><br>
					<img style="width: 200px; height: 200px; margin: auto; border-radius: 5px; border: 3px  #405d9b solid;" src="img/<?php echo "$s->nom";?>.jpg">
					<h3 style="color:#405d9b;"><?php echo $s->nom;?></h3>
					<h3 style="font-size: 12px;"><?php echo $description;?></h3><br/>
					<a id="link" href="actuSupp.php?id=<?php echo $s->id;?>">Supprimer</a>
					<br><br>
				</center></div>
			</center>
			<?php

		}
	}else{
		$user_id = $_SESSION['user_id'];

		$db = new PDO('mysql:host=localhost;dbname=id16129291_stlovac;charset=utf8mb4', 'id16129291_cavolts','6h6h-WBbp(H!021s');	
		$select = $db->prepare("SELECT * FROM actu ");
		$select->execute();

		while ($s=$select->fetch(PDO::FETCH_OBJ)) {
			$lenght = 500;
			$description = $s->description;
			
			
			?>
			<center>
				<div style="background-color: white; width: 500px; margin: 5px;text-align: center;font-weight: bold;position: right;filter: drop-shadow(0 0 0.2rem #405d9b);"><center>
					<br><br>
					<div id="actu">
						<img style="width: 200px; height: 200px; margin: auto; border-radius: 5px; border: 3px  #405d9b solid;" src="img/<?php echo "$s->nom";?>.jpg">
						<h3 style="color:#405d9b;"><?php echo $s->nom;?></h3>
						<h3 style="font-size: 12px;"><?php echo $description;?></h3><br/>
						
						
						<br><br>
					</center></div>
				</center>
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