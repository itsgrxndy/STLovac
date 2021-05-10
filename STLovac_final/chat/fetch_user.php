<?php

include('database_connection.php');
session_start();

$query = "
SELECT * FROM membres 
WHERE id != '".$_SESSION['user_id']."' 
";

$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();

$output = '

<table id="tableau" class="table table-bordered table-striped">
 <tr>
  <th id ="nom"><h4>Nom et Prénom</h4></td>
  <th id="action"><h4>Action<h4></td>
 </tr>
';


$sel = $connect->prepare('SELECT DISTINCT to_user_id, from_user_id FROM chat_message WHERE from_user_id = ? OR to_user_id = ?');
$sel->execute(array($_SESSION['user_id'],$_SESSION['user_id']));
while($w = $sel->fetch()){
	if($w['to_user_id']== $_SESSION['user_id']){
		$base2 = $connect->prepare('SELECT * FROM membres WHERE id = ?');
		$base2->execute(array($w['from_user_id']));
		while ($row = $base2->fetch()) {
			if($row['nomprenom'] != $_SESSION['user_nomprenom']){
				$status = '';
				$test = $_SESSION['user_id'].''. $row['id'];
				$current_timestamp = strtotime(date("Y-m-d H:i:s") . '- 10 second');
				$current_timestamp = date('Y-m-d H:i:s', $current_timestamp);
				$user_last_activity = fetch_user_last_activity($row['email'], $connect);
				
				 if($user_last_activity > $current_timestamp)
				 {
				$output .= '
				<tr>
				<td>'.$row['nomprenom'].'   <img src="vert.jpg" style="width: 15px; height: 15px; border: white 1px solid; border-radius: 50%;">'.count_unseen_message($row['id'], $_SESSION['user_id'], $connect).' '.fetch_is_type_status($row['id'], $connect).'</td>
				<td><button type="button" id="button" class="btn btn-info btn-xs start_chat" data-touserid="'.$row['id'].'" data-tousername="'.$row['nomprenom'].'">Message</button></td>
				</tr>';
				 }
				 else
				 {
				$output .= '
				<tr>
				<td>'.$row['nomprenom'].'   <img src="rouge.jpg" style="width: 15px; height: 15px; border: white 1px solid; border-radius: 50%;">'.count_unseen_message($row['id'], $_SESSION['user_id'], $connect).' '.fetch_is_type_status($row['id'], $connect).'</td>
				<td><button type="button" id="button" class="btn btn-info btn-xs start_chat" data-touserid="'.$row['id'].'" data-tousername="'.$row['nomprenom'].'">Message</button></td>
				</tr>';
				 }
			}
		}
	} 
}

$output .= '</table>';

echo $output;

?>

