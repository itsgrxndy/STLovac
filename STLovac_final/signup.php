<?php
/*
ob_start --> header sur 000webhost
verification qu'un compte n'est pas déja lancer 
connexion à la base de donnée
*/
ob_start();
session_start();
if(!isset($_SESSION['user_id']) AND empty($_SESSION['user_id'])) {


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
<!--
formulaire d'inscription 
metode post | enctype multipart/form-data photo
-->
<!DOCTYPE html>
<html>
<head>
	<title>STLovac | Inscription</title>
	<meta charset='utf8mb4'>
	<link rel="stylesheet" type="text/css" href="style/login.css">
</head>
<body>
	<div id="bar">
		<div style="font-size: 40px;">STLovac</div>
		<div id="signup_button"><a href="login.php">Connexion</a></div>

	</div>
	<div id="bar2">
		Inscription STLovac<br><br>
		<form method="post" enctype="multipart/form-data">
			<input type="text" id="text" placeholder="Nom" name="nom"><br><br>
			<input type="text" id="text" placeholder="Prénom" name="prenom"><br><br>
			<span style="font-family: normal;">Sexe : </span><br>
			<select id="text" name="gern">
				<option>Homme</option>
				<option>Femme</option>
				<option>Non binaire</option>
			</select><br><br>
			<input type="email" id="text" placeholder="Email" name="email"><br><br>
			<span style="font-family: normal;">Classe : </span><br>
			<select id="text" name="classe">
				<option>Terminale</option>
				<option>Première</option>
				<option>Seconde</option>
			</select><br><br>

			<input type="password" id="text" placeholder="Mot de passe" name="mdp"><br><br>
			<input type="password" id="text" placeholder="Confirmation mot de passe" name="cmdp"><br><br>
			<input type="text" id="text" placeholder="Description" name="description"><br><br>

			<input type="text" id="text" placeholder="Entrez votre snap" name="snap"><br><br>
			<input type="text" id="text" placeholder="Entrez votre insta" name="insta"><br><br>

			<span style="font-family: normal;">Photo de profil : </span><br>
			<input type="file" name="imgp"/><br><br>
			<span style="font-family: normal;">Bannière : </span><br>
			<input type="file" name="imgf"/><br><br>

			<input type="submit" id="button" value="S'inscrire" name="submit"><br><br><br>
		</form>
	</div>
</body>
</html>

<?php
/*
insertion donnée dans table membres 
insertion des 2 photos dans le dossier img_profil
*/
if (isset($_POST['submit'])){ 
	$nom = $_POST['nom'];
	$prenom = $_POST['prenom'];
	$email = $_POST['email'];
	$gern=$_POST['gern'];
	$mdp = $_POST['mdp'];
	$cmdp = $_POST['cmdp'];
	$description = $_POST['description'];
	$classe = $_POST['classe'];
	$snap = $_POST['snap'];
	$insta = $_POST['insta'];

	if($nom&$prenom&$email&$gern&$mdp&$cmdp&$description){
		if($mdp == $cmdp){
			$mdp1 = password_hash($mdp, PASSWORD_DEFAULT);
			$db->query("INSERT INTO membres (nom,prenom,email,mdp,gern,description,nomprenom,classe,snap,insta) VALUES('$nom','$prenom','$email','$mdp1','$gern','$description','$nom $prenom','$classe','$snap','$insta')");
			$sub_query = "
			INSERT INTO login_details 
			(user_email) 
			VALUES ('$email')
			";
			$statement = $db->prepare($sub_query);
			$statement->execute();

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

						imagejpeg($image_final,'img_profil/profile/'.$email.'.jpg');


					}
				}
			}else{

				echo "Veuillez rentrer une image ";
			}

			$imgf = $_FILES['imgf']['name'];
			$imgf_tmp = $_FILES['imgf']['tmp_name'];

			if(!empty($imgf_tmp)){
				$image1 = explode('.', $imgf);
				$image_ext1 = end($image1);

				if (in_array(strtolower($image_ext1),array('png','jpg','jpeg'))===false){

					echo "Veuillez rentrer une image ayant pour extention : png, jpg, jpeg.";
				}else{

					$image_size1 = getimagesize($imgf_tmp);
					if($image_size1['mime']=='image/jpeg'){

						$image_src1 = imagecreatefromjpeg($imgf_tmp);
					}elseif($image_size1['mime']=='image/png'){

						$image_src1 = imagecreatefrompng($imgf_tmp);
					}else{

						$image_src1 = false;
						echo "rentrer une image valide";

					}
					if($image_src1!== false){

						$image_width1=800;

						if($image_size1[0]==$image_width1){

							$image_final1 = $image_src1;

						}else{

							$new_width1[0]=$image_width1;
							$new_height1[1] = 300;

							$image_final1 = imagecreatetruecolor($new_width1[0], $new_height1[1]);

							imagecopyresampled($image_final1,$image_src1,0,0,0,0,$new_width1[0],$new_height1[1],$image_size1[0],$image_size1[1]);

						}

						imagejpeg($image_final1,'img_profil/fond/'.$email.'.jpg');


					}
				}
			}else{

				echo "Veuillez rentrer une image ";
			}

			header("Location:login.php");

		}else{
			echo "le mot de passe et la confirmation du mot de passe ne sont pas pareil";
		}
	}else{
		echo "Veillez remplir tous les champs";
	}
}
}else{
	header("Location:profile.php");
}
?>