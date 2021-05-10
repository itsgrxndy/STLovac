<?php
//connection base de donnée
$connect = new PDO('mysql:host=localhost;dbname=id16129291_stlovac;charset=utf8mb4', 'id16129291_cavolts','6h6h-WBbp(H!021s');
//information sur l'heure (la table de donnée a comme horaire celle de londre donc le programme prend londre aussi)
date_default_timezone_set('Europe/London');

function fetch_user_last_activity($user_email, $connect)
{
//selection info sur lheure de la dernière activité
 $query = "
 SELECT * FROM login_details 
 WHERE user_email = '$user_email' 
 ORDER BY last_activity DESC 
 LIMIT 1
 ";
 $statement = $connect->prepare($query);
 $statement->execute();
 $result = $statement->fetchAll();
 foreach($result as $row)
 {
  return $row['last_activity'];
}
}

function fetch_user_chat_history($from_user_id, $to_user_id, $connect)
{
//selection des ancien message entre 2 personne
 $query = "
 SELECT * FROM chat_message 
 WHERE (from_user_id = '".$from_user_id."' 
 AND to_user_id = '".$to_user_id."') 
 OR (from_user_id = '".$to_user_id."' 
 AND to_user_id = '".$from_user_id."') 
 ORDER BY timestamp ASC 
 ";
 $statement = $connect->prepare($query);
 $statement->execute();
 $result = $statement->fetchAll();
 $output = '<ul class="list-unstyled">';
 foreach($result as $row)
 {
  $user_name = '';
  if($row["from_user_id"] == $from_user_id)
  {
   $user_name = '<b class="text-success">Toi</b>';
 }
 else
 {
   $user_name = '<b class="text-danger">'.get_user_name($row['from_user_id'], $connect).'</b>';
 }
 $output .= '
 <li style="border-bottom:1px dotted #ccc">
 <p>'.$user_name.' - '.$row["chat_message"].'
 <div align="right">
 - <small><em>'.$row['timestamp'].'</em></small>
 </div>
 </p>
 </li>
 ';
}
$output .= '</ul>';
$query = "
UPDATE chat_message 
SET status = '0' 
WHERE from_user_id = '".$to_user_id."' 
AND to_user_id = '".$from_user_id."' 
AND status = '1'
";
$statement = $connect->prepare($query);
$statement->execute();
return $output;
}

function get_user_name($user_id, $connect)
{
// selection du nom et du prenom
 $query = "SELECT nomprenom FROM membres WHERE id = '$user_id'";
 $statement = $connect->prepare($query);
 $statement->execute();
 $result = $statement->fetchAll();
 foreach($result as $row)
 {
  return $row['nomprenom'];
}
}

function count_unseen_message($from_user_id, $to_user_id, $connect)
{
//compte le nom de message pas ouver
 $query = "
 SELECT * FROM chat_message 
 WHERE from_user_id = '$from_user_id' 
 AND to_user_id = '$to_user_id' 
 AND status = '1'
 ";
 $statement = $connect->prepare($query);
 $statement->execute();
 $count = $statement->rowCount();
 $output = '';
 if($count > 0)
 {
  $output = '<span class="label label-success">'.$count.'</span>';
}
return $output;
}

function fetch_is_type_status($user_id, $connect)
{
// statu de la personne (en ligne, hors connexion)
 $query = "
 SELECT is_type FROM login_details 
 WHERE user_id = '".$user_id."' 
 ORDER BY last_activity DESC 
 LIMIT 1
 "; 
 $statement = $connect->prepare($query);
 $statement->execute();
 $result = $statement->fetchAll();
 $output = '';
 foreach($result as $row)
 {
  if($row["is_type"] == 'yes')
  {
   $output = ' - <small><em><span class="text-muted">Typing...</span></em></small>';
 }
}
return $output;
}



?>
