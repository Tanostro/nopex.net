<?php
$mysqli = @new mysqli('############', '############', '############', '############');
if ($mysqli->connect_error){
  $errorMsg = $CONTENT["database_connection_error"];
} else
if (!empty($_POST)){
  if ( !empty($_POST["password"]) AND !empty($_POST["password2"])){
    if ($_POST["password"] == $_POST["password2"]){
      $email = mysqli_escape_string( $mysqli ,$_GET["email"]);
      $query = "SELECT uuid FROM users WHERE email='$email' ";
      $result = $mysqli->query($query);
      $count = mysqli_num_rows($result);
      foreach ($result as $row);

      if ($count > 0){
        $uuid = $row["uuid"];
        $query = "SELECT email_reset_code FROM verification WHERE uuid='$uuid' ";
        $result = $mysqli->query($query);
        foreach ($result as $row);
      }

      $query = "UPDATE verification SET email_reset_code='' WHERE uuid='$uuid'";
      $mysqli->query($query);
      $salt = '';
      for ($i = 0; $i < 22; $i++) {
        $salt .= substr('./ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789', mt_rand(0, 63), 1);
      }
      $password = crypt($_POST['password'],'$2a$10$' . $salt);
      $query = "UPDATE users SET password='$password' WHERE uuid='$uuid'";
      $mysqli->query($query);

      header('Location: http://'.$_SERVER['HTTP_HOST'].'/account/login');
    } else {
      $errorMsg = $CONTENT["passwords_dont_match"];
    }
  }
}?>
