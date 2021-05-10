<?php
if(isset($_POST['mailmdp'])){
$header ="MIME-Version: 1.0\r\n";
$header.='From:"STLovac"<stlovac.mail@gmail.com>'."\n";
$header.='Content-Type:text/html; charset="utf8mb4"'."\n";
$header.='Content-Transfer-Encoding: 8bits';

$message='
<html>
	<body>
		<div align="center">
			jai envoyer se message par php!
		</div>
	</body>
</html>
'
mail("kylian.grandy@gmail.com", "test", $message, $header);
}
?>
<form method="post" action="">
	<input type="submit" name="mailmdp" value="envoyer un mail !">
</form>