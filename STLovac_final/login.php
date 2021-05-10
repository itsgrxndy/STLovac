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
	<!-- formulaire de connexion -->
	<!DOCTYPE html>
	<html>
	<head>
		<title>STLovac | Connexion</title>
		<meta charset='utf8mb4'>
		<link rel="stylesheet" type="text/css" href="style/login.css">
	</head>
	<body>
		<div id="bar">
			<div style="font-size: 40px;">STLovac</div>
			<div id="signup_button"><a href="signup.php">Inscription</a></div>
		</div>
		<div id="bar2">
			Connexion STLovac<br><br>
			<form method="post">
				<input type="email" id="text" placeholder="Email" name="email"><br><br>
				<input type="password" id="text" placeholder="Mot de passe" name="mdp"><br><br>
				<input type="submit" id="button" value="Se connecter" name="submit"><br><br><br>
				<a id="link" href="mdpO.php">mot de passe oublier</a>
			</form>
		</div>
	</body>
	</html>

	<?php



	if (isset($_POST['submit'])) {
		$email = $_POST['email'];
		$password = $_POST['mdp'];

		if($email&&$password){

			$select = $db->query("SELECT id FROM membres WHERE email='$email'");
			if($select->fetchColumn()){
				$select = $db->query("SELECT * FROM membres WHERE email='$email'");
				$result = $select->fetch(PDO::FETCH_OBJ);
				if (password_verify($password, $result->mdp)){
					$id = $result->id;
					
					$query = "
					UPDATE login_details 
					SET last_activity = now() 
					WHERE user_email = '".$_SESSION['user_email']."'
					";
					
					$statement = $db->prepare($query);
					
					$statement->execute();
//création de toute les variable session
					$_SESSION['user_id'] = $id;
					$_SESSION['user_nom'] = $result->nom;
					$_SESSION['user_prenom'] = $result->prenom;
					$_SESSION['user_email'] = $result->email;
					$_SESSION['user_mdp'] = $result->mdp;
					$_SESSION['user_nomprenom'] = $result->nomprenom;
					$_SESSION['login_details_id'] = $db->lastInsertId();
					header('Location:profile.php');
				}else{
					echo "Mauvais mot de passe";
				}
			}else{

				echo "Mauvais email";

			}

		}else{
			echo "Veuilez remplir tout les champs";
		}
		
	}

}else{
	header("Location:profile.php");
}
?>