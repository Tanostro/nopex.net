<?php
$mysqli = @new mysqli('############', '############', '############', '############');
if ($mysqli->connect_error){
  $errorMsg = $CONTENT["database_connection_error"];
} else
if (!empty($_POST)){
  if ( !empty($_POST["email"])){
    $email = mysqli_escape_string( $mysqli ,$_POST["email"]);
    $query = "SELECT uuid FROM users WHERE email='$email' ";
    $result = $mysqli->query($query);
    $count = mysqli_num_rows($result);
    foreach ($result as $row);

    if ($count > 0){
      $uuid = $row["uuid"];
      $query = "SELECT email_reset_code FROM verification WHERE uuid='$uuid' ";
      $result = $mysqli->query($query);
      foreach ($result as $row);
      if (empty($row["email_reset_code"])){
        $code = substr(str_shuffle("01234567890123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 24);
        $query = "UPDATE verification SET email_reset_code='$code' WHERE uuid='$uuid'";
        $mysqli->query($query);
      } else {
        $code = $row["email_reset_code"];
      }
      $email = $_POST["email"];
      $subject = 'Password reset';
      require("../../mail/reset_email.php");
      require('../../mail/send_email.php');
      header('Location: http://' . $_SERVER['HTTP_HOST'] . '/account/login/reset-password?send=true');

    }
  }
}?>
