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
	$user_id=$_SESSION['user_id'];
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
		<a href="profile.php"><img src="../img_profil/profile/<?php echo "$s->email";?>.jpg" title="Profile" style="width: 50px; float: right; border-radius: 50%; "></a> 	
		<a href="actu.php"><img src="../stmarc.png" title="Actualité" style="width: 50px; float: right; border-radius: 50%;"></a>
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
<div id="modifier">
	<center>
		<form action="" method="post" enctype="multipart/form-data">
			<h3>Photo de profil</h3>
			<input type="file" name="imgp"/></br></br><br>
			<input type="submit" name="submit" value="Modifier" id="button"><br>			
		</form>
	</center>
</form>
</div>


<?php

$db = new PDO('mysql:host=localhost;dbname=id16129291_stlovac;charset=utf8', 'id16129291_cavolts','6h6h-WBbp(H!021s');
$user_id = $_SESSION['user_id'];
$select = $db->prepare("SELECT * FROM membres WHERE id=$user_id");
$select->execute();

$data = $select->fetch(PDO::FETCH_OBJ);

$email = $data->email;

if(isset($_POST['submit'])){

	$imgp = $_FILES['imgp']['name'];
	$imgp_tmp = $_FILES['imgp']['tmp_name'];

	if(!empty($imgp_tmp)){
		$image = explode('.', $imgp);
		$image_ext = end($image);

		if (in_array(strtolower($image_ext),array('png','jpg','jpeg'))===false){

			echo "Veuillez rentrer une image ayant pour extention : png, jpg, jpeg.";
		}else{

			$image_size = getimagesize($imgp_tmp);
			if($image_size['mime']=='image/jpeg'){

				$image_src = imagecreatefromjpeg($imgp_tmp);
			}elseif($image_size['mime']=='image/png'){

				$image_src = imagecreatefrompng($imgp_tmp);
			}else{

				$image_src = false;
				echo "rentrer une image valide";

			}
			if($image_src!== false){

				$image_width=200;

				if($image_size[0]==$image_width){

					$image_final = $image_src;

				}else{

					$new_width[0]=$image_width;
					$new_height[1] = 200;

					$image_final = imagecreatetruecolor($new_width[0], $new_height[1]);

					imagecopyresampled($image_final,$image_src,0,0,0,0,$new_width[0],$new_height[1],$image_size[0],$image_size[1]);

				}

				imagejpeg($image_final,'../img_profil/profile/'.$email.'.jpg');


			}
		}
	}else{

		echo "Veuillez rentrer une image ";
	}
	header('Location:../profile.php');
}
}else{
	header("Location:login.php");
}