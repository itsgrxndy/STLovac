<?php
/*
ob_start --> header sur 000webhost
inseré le header contenant la connexion a la base de donnée
*/
ob_start();
require_once('../includes/header.php');
?>
<?php
//ajouter information dans la table favoris
if(isset($_GET['id']) AND !empty($_GET['id'])) {
   $getid = (int) $_GET['id'];
   $user_id=$_SESSION['user_id'];
   $check = $db->prepare('SELECT id FROM membres WHERE id = ?');
   $check->execute(array($getid));
   if($check->rowCount() == 1) {
      $check_like = $db->prepare('SELECT id FROM favoris WHERE id_destinataire = ? AND id_membre = ?');
      $check_like->execute(array($getid,$user_id));
      if($check_like->rowCount() == 1) {
         $del = $db->prepare('DELETE FROM favoris WHERE id_destinataire = ? AND id_membre = ?');
         $del->execute(array($getid,$user_id));
      } else {
         $ins = $db->prepare('INSERT INTO favoris (id_destinataire, id_membre) VALUES (?, ?)');
         $ins->execute(array($getid, $user_id));
      } 
      header('Location: ../membresPage.php?id='.$getid);
   } else {
      exit('Erreur fatale. <a href="../actu.php">Revenir à l\'accueil</a>');
   }
} else {
   exit('Erreur fatale. <a href="../actu.php">Revenir à l\'accueil</a>');
}