<?php
//ob_start --> header sur 000webhost
ob_start();
?>
<html>
<head>
	<title>STLovac | Modifier</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="style/login.css">
</head>
<body>
	<div id="bar">
		<div style="font-size: 40px;">STLovac</div>
	</div>
	<div id="bar2">
		Modifier mot de passe<br><br>
		
		<form action="" method="post" enctype="multipart/form-data">
			<h3>Mot de passe :</h3>
			<input type="password" name="mdp" id="text" placeholder="votre nouveau mot de passe"><br>

			<input type="submit" name="submit" value="Modifier" id="button" >	
		</form>
	</div>
</body>
</html>


<?php
if(isset($_POST['submit'])){
//modification du mot de passe 
	$mdp=$_POST['mdp'];
	$user_id=htmlspecialchars($_GET['id']);
	$mdp1 = password_hash($mdp, PASSWORD_DEFAULT);
	$db = new PDO('mysql:host=localhost;dbname=id16129291_stlovac;charset=utf8mb4', 'id16129291_cavolts','6h6h-WBbp(H!021s');
	$update = $db->prepare("UPDATE membres SET mdp='$mdp1' WHERE id=$user_id");
	$update->execute();

	header("Location: login.php");
}

?>