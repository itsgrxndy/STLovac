<?php
//connexion a la base de donnée
try
{
	$db = new PDO('mysql:host=localhost;dbname=id16129291_stlovac;charset=utf8mb4', 'id16129291_cavolts','6h6h-WBbp(H!021s');
	$db->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
	$db->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
	
}
catch(Exception $e){
	echo "une erreur est survenue";
	die();
}?>
<!-- formulaire pour envoyer un mail a la bonne personne -->
<!DOCTYPE html>
<html>
<head>
	<title>STLovac | Mot de passe</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="style/login.css">
</head>
<body>
	<div id="bar">
		<div style="font-size: 40px;">STLovac</div>
		<div id="signup_button"><a href="login.php">connexion</a></div>
	</div>
	<div id="bar2">
		Mot de passe oublié<br><br>
		<form method="post" action="">
            <input type="email" id="text" name="email" placeholder="votre mail...">
            <input type="submit" id="button" name="mailmdp" value="envoyer un mail !">
        </form>
    </div>
</body>
</html>

<?php

if(isset($_POST['mailmdp'])){
    $email = $_POST['email'];
    $select = $db->query("SELECT * FROM membres WHERE email='$email'");
    $s = $select->fetch(PDO::FETCH_OBJ);
    if($email){
        $mdp = $s->mdp;
        $id = $s->id;
        $header ="MIME-Version: 1.0\r\n";
        $header.='From:"STLovac"<stlovac.mail@gmail.com>'."\n";
        $header.='Content-Type:text/html; charset="utf8mb4"'."\n";
        $header.='Content-Transfer-Encoding: 8bits';
        
        $message='
        <html>
        <body>
        <div align="center">
        <h3>votre mot de passe est <a href="https://stlovac.000webhostapp.com/modifierMdp.php?id='.$id.'"> Modifier mdp</a></h3>
        
        <a href="modifierMdp.php&id='.$id.'> Modifier mdp</a>
        </div>
        </body>
        </html>
        ';
//fonction php pour envoyer un mail (il faut etre sur un hebergeur)
        mail($email, "Récupération mot de passe", $message, $header);
        echo "mail bien envoyé a ".$email." bonne journée";
    }else{
        echo "erreur";
    }

}
?>
