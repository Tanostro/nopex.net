<?php
$mysqli = @new mysqli('############', '############', '############', '############');
if ($mysqli->connect_error){
  $errorMsg = $CONTENT["database_connection_error"];
} else
if (!empty($_POST)){
  if ( !empty($_POST["username"]) &&
      !empty($_POST["email"]) &&
      !empty($_POST["email2"]) &&
      !empty($_POST["password"]) &&
      !empty($_POST["password2"]) &&
      !empty($_POST["agb-check"])
  ){
    if ($_POST["email"] != $_POST["email2"]){
      $errorMsg = $CONTENT["emails_dont_match"];
    } else
    if($_POST["password"] != $_POST["password2"]) {
      $errorMsg = $CONTENT["passwords_dont_match"];
    } else
     if (strlen($_POST["username"]) > 16 ){
      $errorMsg = $CONTENT["username_max_lengh"];
    } else {
      $email = mysqli_escape_string( $mysqli ,$_POST["email"]);
      $query = "SELECT email FROM users WHERE email='$email' ";
      $result = $mysqli->query($query);
      $count = mysqli_num_rows($result);

      if ($count == 0){
        $salt = '';
        for ($i = 0; $i < 22; $i++) {
          $salt .= substr('./ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789', mt_rand(0, 63), 1);
        }
        $password = crypt($_POST['password'],'$2a$10$' . $salt);
        $username = mysqli_escape_string($mysqli ,$_POST["username"]);
        $query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";

        $result = $mysqli->query($query);
        if (!empty($mysqli->error)){
          $errorMsg =  $CONTENT["error_creating_account"];
        } else {
          $query = "SELECT uuid FROM users WHERE email='$email'";
          $result = $mysqli->query($query);
          foreach ($mysqli->query($query) as $row);
          $uuid = $row["uuid"];
          $verCode = substr(str_shuffle("01234567890123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 6);
          $query = "INSERT INTO verification (uuid, email_code) VALUES ($uuid, '$verCode')";
          $mysqli->query($query);
          $subject = 'E-Mail Verification';
          require("../mail/ver_email.php");
          require('../mail/send_email.php');

          $_SESSION = array(
            'login' => true,
            'user'  => array(
              'uuid'  => $uuid,
              'name'  => $_POST['username'],
              'email'  => $_POST['email'],
              'ver_league'  => false,
              'ver_email'  => false,
            )
          );

          header('Location: http://' . $_SERVER['HTTP_HOST'] . '/account/create/email-verification');

        }

      } else { $errorMsg = $CONTENT["email_already_in_use"]; }
    }
  } else { $errorMsg = $CONTENT["empty_form"]; }
} ?>
