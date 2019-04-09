<?php
$mysqli = @new mysqli('############', '############', '############', '############');
if ($mysqli->connect_error){
  $errorMsg = $CONTENT["database_connection_error"];
} else
if (!empty($_POST)){
  if ( !empty($_POST["ver-code"])){

    $uuid = $_SESSION['user']['uuid'];
    $query = "SELECT email_code FROM verification WHERE uuid='$uuid' ";
    $result = $mysqli->query($query);
    foreach ($result as $row);
    if ($_POST["ver-code"] == $row["email_code"]){
      $query = "UPDATE users SET ver_email=true WHERE uuid='$uuid' ";
      $mysqli->query($query);
      $_SESSION['user']['ver_email'] = true;
      header ('Location: http://'.$_SERVER['HTTP_HOST'].'/create/add-league-account');
    } else { $errorMsg = $CONTENT["wrong-code"]; }
  }
} ?>
