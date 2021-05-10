<?php
/*
ob_start --> header sur 000webhost
inseré le header contenant la connexion a la base de donnée
*/
ob_start();

require_once('includes/header.php');

?>
<!-- formulaire pour ajouter actu -->
<!DOCTYPE html>
<html>
<head>
	<title>Ajout actu | STLovac</title>
	<meta charset='utf8mb4'>
	<link rel="stylesheet" type="text/css" href="style/login.css">
</head>
<body>
	<div id="bar">
		<div style="font-size: 40px;">STLovac</div>
		<div id="signup_button"><a href="actu.php">retour actu</a></div>
		
	</div>
	<div id="bar2">
		<form method="post" enctype="multipart/form-data">
		<input type="text" id="text" placeholder="Nom de l'actualité" name="nom"><br><br>
		<input type="text" id="text" placeholder="Description de l'actualité" name="description"><br><br>

		<span style="font-family: normal;">Photo de profil : </span><br>
		<input type="file" name="imgp"/><br><br>

		<input type="submit" id="button" value="Ajouter" name="submit"><br><br><br>
	</form>
	</div>
</body>
</html>

<?php
//insertion de l'actu dans la table actu 
//insertion de l'image dans img
if (isset($_POST['submit'])){
	$nom = $_POST['nom'];
	$description = $_POST['description'];

	if($nom&$description){

		$db->query("INSERT INTO actu (nom,description) VALUES('$nom','$description')");

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

					imagejpeg($image_final,'img/'.$nom.'.jpg');


				}
			}
		}else{

			echo "Veuillez rentrer une image ";
		}
			header('Location:actu.php');
	}else{
		echo "Veillez remplir tous les champs";
	}
}
?>