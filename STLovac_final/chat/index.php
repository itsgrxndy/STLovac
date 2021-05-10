<?php

include('database_connection.php');

require_once('../includes/header.php');
if(isset($_SESSION['user_id']) AND !empty($_SESSION['user_id'])) {
    $query = "
UPDATE login_details 
SET last_activity = now() 
WHERE user_email = '".$_SESSION['user_email']."'
";

$statement = $db->prepare($query);

$statement->execute();
?>

<html>  
    <head>  
        <title>Messagerie | STLovac</title>  
        <link rel="stylesheet" type="text/css" href="../style/messagerie.css">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.rawgit.com/mervick/emojionearea/master/dist/emojionearea.min.css">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script src="https://cdn.rawgit.com/mervick/emojionearea/master/dist/emojionearea.min.js"></script>
        <meta charset="utf-8">
    </head>  
    <body style="font-family: tahoma; background-color: #d0d8e4;">  
        
    <br />

    <?php
    $user_id=$_SESSION['user_id'];
    $select = $db->query("SELECT * FROM membres WHERE id='$user_id'");

    while($s = $select->fetch(PDO::FETCH_OBJ)){
      ?>
      <br>
      <form method="GET">
        <div id="blue_bar">
          <div style="width: 800px; margin: auto; font-size: 40px;">
            
            StLovac &ensp;          
            <a href="../profile.php"><img src="../img_profil/profile/<?php echo "$s->email";?>.jpg" title="Profile" style="width: 50px; float: right; border-radius: 50%; "></a>  
            <a href="../actu.php"><img src="../stmarc.png" title="Actualité" style="width: 50px; float: right; border-radius: 50%;"></a>
          </div>
        </div>
      </form>
      <div style="width: 800px; margin: auto; background-color: black; min-height: 300px;">
        <div style="background-color: white; text-align: center; color: #405d9b">
          <img src="../img_profil/fond/<?php echo "$s->email";?>.jpg" style="width: 100%; height: 300px;">
          <img src="../img_profil/profile/<?php echo "$s->email";?>.jpg" id="profile_pic">
          <br>
          <h3><?php echo $s->nom; ?> &nbsp <?php echo $s->prenom; ?></h3>
          <br>
        <nav>
          <a href="../actu.php">Actualité</a>
          <a href="../membres.php">Membres</a>
          <a href="../chat/index.php">Messages</a>
          <a href="../public.php">Crush</a>
          <a href="../profile.php">Profil</a>
          <a href="../modifier.php">Modifier</a>
        </nav> 
        </div>
      </div>

      <?php
    }
    ?>

  <div id="block">
  <h3 align="center" style="font-family: tahoma; color: #405d9b; font-size: 20px;">STLovac messagerie</h3><br />
  <a id="link" href="../profile.php">Profil</a><br><br>
    <div id="user_details"></div>
    <div id="user_model_details"></div>
   </div>
  </div>
</body>  
</html>  

<div class="container">

<?php

//_________________________________________________________________________________________________________________________________________________________
if(isset($_GET['id'])) {
  $query = "
  SELECT * FROM membres 
  WHERE id != '".$_SESSION['user_id']."' 
  ";

  $statement = $connect->prepare($query);

  $statement->execute();

  $result = $statement->fetchAll();

  $output = '
  <div style="background-color: white; width: 800px; margin: auto; margin-top: 5px;padding: 10px;padding-top: 50px;text-align: center;font-weight: bold;">
  <div style="  background-color: white;   width: 700px;  margin: 5px;  text-align: center;  font-weight: bold;  position: center;  filter: drop-shadow(0 0 0.2rem #405d9b);">
  <table id="tableau" class="table table-bordered table-striped">
  ';


  $id = intval($_GET['id']);
  if($id != null){
    $base = $connect->prepare('SELECT * FROM membres WHERE id = ?');
    $base->execute(array($id));
    while ($row = $base->fetch()) {
      $status = '';
      $current_timestamp = strtotime(date("Y-m-d H:i:s") . '- 10 second');
      $current_timestamp = date('Y-m-d H:i:s', $current_timestamp);
      $output .= '
      <h3 style="font-family: tahoma; color: #405d9b;">Nouveau message</h3>
      <h5 style="font-family: tahoma; color: #405d9b;">La conversation apparaiteras quand le contact aura répondu</h5>
      <tr>
      <td style="width : 70%; ">'.$row['nomprenom'].' '.count_unseen_message($row['id'], $_SESSION['user_id'], $connect).' '.fetch_is_type_status($row['id'], $connect).'</td>
      <td style="width : 20%; "><button type="button" id="button" class="btn btn-info btn-xs start_chat" data-touserid="'.$row['id'].'" data-tousername="'.$row['nomprenom'].'">Message</button></td>
      </tr>
      <br><br>
      </div>
      </div>
      ';
    }
  }
  $output .= '</table>';

  echo $output;
}

//______________________________________________________________________________________________________________________________________________________________



?>

<script>  
$(document).ready(function(){

 fetch_user();

 setInterval(function(){
  update_last_activity();
  fetch_user();
  update_chat_history_data();
 }, 5000);

 function fetch_user()
 {
  $.ajax({
   url:"fetch_user.php",
   method:"POST",
   success:function(data){
    $('#user_details').html(data);
   }
  })
 }

 function update_last_activity()
 {
  $.ajax({
   url:"update_last_activity.php",
   success:function()
   {

   }
  })
 }

 function make_chat_dialog_box(to_user_id, to_user_name)
 {
  var modal_content = '<div id="user_dialog_'+to_user_id+'" class="user_dialog" title="You have chat with '+to_user_name+'">';
  modal_content += '<div style="height:400px; border:1px solid #ccc; overflow-y: scroll; margin-bottom:24px; padding:16px;" class="chat_history" data-touserid="'+to_user_id+'" id="chat_history_'+to_user_id+'">';
  modal_content += fetch_user_chat_history(to_user_id);
  modal_content += '</div>';
  modal_content += '<div class="form-group">';
  modal_content += '<textarea name="chat_message_'+to_user_id+'" id="chat_message_'+to_user_id+'" class="form-control chat_message"></textarea>';
  modal_content += '</div><div class="form-group" align="right">';
  modal_content+= '<button type="button" name="send_chat" id="'+to_user_id+'" class="btn btn-info send_chat">Send</button></div></div>';
  $('#user_model_details').html(modal_content);
 }

 $(document).on('click', '.start_chat', function(){
  var to_user_id = $(this).data('touserid');
  var to_user_name = $(this).data('tousername');
  make_chat_dialog_box(to_user_id, to_user_name);
  $("#user_dialog_"+to_user_id).dialog({
   autoOpen:false,
   width:400
  });
  $('#user_dialog_'+to_user_id).dialog('open');
  $('#chat_message_'+to_user_id).emojioneArea({
   pickerPosition:"top",
   toneStyle: "bullet"
  });
 });

 $(document).on('click', '.send_chat', function(){
  var to_user_id = $(this).attr('id');
  var chat_message = $('#chat_message_'+to_user_id).val();
  $.ajax({
   url:"insert_chat.php",
   method:"POST",
   data:{to_user_id:to_user_id, chat_message:chat_message},
   success:function(data)
   {
    //$('#chat_message_'+to_user_id).val('');
    var element = $('#chat_message_'+to_user_id).emojioneArea();
    element[0].emojioneArea.setText('');
    $('#chat_history_'+to_user_id).html(data);
   }
  })
 });

 function fetch_user_chat_history(to_user_id)
 {
  $.ajax({
   url:"fetch_user_chat_history.php",
   method:"POST",
   data:{to_user_id:to_user_id},
   success:function(data){
    $('#chat_history_'+to_user_id).html(data);
   }
  })
 }

 function update_chat_history_data()
 {
  $('.chat_history').each(function(){
   var to_user_id = $(this).data('touserid');
   fetch_user_chat_history(to_user_id);
  });
 }

 $(document).on('click', '.ui-button-icon', function(){
  $('.user_dialog').dialog('destroy').remove();
 });

 $(document).on('focus', '.chat_message', function(){
  var is_type = 'yes';
  $.ajax({
   url:"update_is_type_status.php",
   method:"POST",
   data:{is_type:is_type},
   success:function()
   {

   }
  })
 });

 $(document).on('blur', '.chat_message', function(){
  var is_type = 'no';
  $.ajax({
   url:"update_is_type_status.php",
   method:"POST",
   data:{is_type:is_type},
   success:function()
   {
    
   }
  })
 });
 
});  
</script>
<?php
}else{
    header("Location:login.php");
}
?>