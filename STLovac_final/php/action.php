<?php
/*
ob_start --> header sur 000webhost
inseré le header contenant la connexion a la base de donnée
*/
ob_start();
require_once('../includes/header.php');
?>
<?php
if(isset($_GET['t'],$_GET['id']) AND !empty($_GET['t']) AND !empty($_GET['id'])) {
   $getid = (int) $_GET['id'];
   $gett = (int) $_GET['t'];
   $user_id=$_SESSION['user_id'];
   $check = $db->prepare('SELECT id FROM membres WHERE id = ?');
   $check->execute(array($getid));
   if($check->rowCount() == 1) {
      if($gett == 1) {
//ajout like
         $check_like = $db->prepare('SELECT id FROM likes WHERE id_destinataire = ? AND id_membre = ?');
         $check_like->execute(array($getid,$user_id));
         $del = $db->prepare('DELETE FROM dislikes WHERE id_destinataire = ? AND id_membre = ?');
         $del->execute(array($getid,$user_id));
         if($check_like->rowCount() == 1) {
            $del = $db->prepare('DELETE FROM likes WHERE id_destinataire = ? AND id_membre = ?');
            $del->execute(array($getid,$user_id));
         } else {
            $ins = $db->prepare('INSERT INTO likes (id_destinataire, id_membre) VALUES (?, ?)');
            $ins->execute(array($getid, $user_id));
         }
//ajout dislike   
      } elseif($gett == 2) {
         $check_like = $db->prepare('SELECT id FROM dislikes WHERE id_destinataire = ? AND id_membre = ?');
         $check_like->execute(array($getid,$user_id));
         $del = $db->prepare('DELETE FROM likes WHERE id_destinataire = ? AND id_membre = ?');
         $del->execute(array($getid,$user_id));
         if($check_like->rowCount() == 1) {
            $del = $db->prepare('DELETE FROM dislikes WHERE id_destinataire = ? AND id_membre = ?');
            $del->execute(array($getid,$user_id));
         } else {
            $ins = $db->prepare('INSERT INTO dislikes (id_destinataire, id_membre) VALUES (?, ?)');
            $ins->execute(array($getid, $user_id));
         }
      }
      header('Location: ../membresPage.php?id='.$getid);
   } else {
      exit('Erreur fatale. <a href="../actu.php">Revenir à l\'accueil</a>');
   }
} else {
   exit('Erreur fatale. <a href="../actu.php">Revenir à l\'accueil</a>');
}