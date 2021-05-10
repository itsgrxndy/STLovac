<?php

//update_last_activity.php

include('database_connection.php');

session_start();

$query = "
UPDATE login_details 
SET last_activity = now() 
WHERE user_email = '".$_SESSION['user_email']."'
";

$statement = $connect->prepare($query);

$statement->execute();

?>