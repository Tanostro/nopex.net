<?php
$_EMAIL_CONTENT = '
<!DOCTYPE html>
<html lang="de">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="https://fonts.googleapis.com/css?family=Oswald:400,700"
rel="stylesheet" type="text/css">
<style>
a { text-decoration: none; color: #2B6CA3;}
</style>
</head>
<body style="margin: 0; padding: 0; background-color: #F2F2F2;">
<div style="max-width: 720px;  margin:auto;">
<div style="padding: 3%; background-color: #F2F2F2;">
<div style="font-family: Oswald; background-color: #2B6CA3; color: white; padding: 10px; margin-bottom: 15px; height: 52px;">
<span style="float: right; font-size: 32px; margin-right: 15px;">Nopex.net</span>
</div>

<div style="padding: 10px;background-color: white;font-family: Oswald;">
<span style="font-family: Oswald; font-size: 24px;">Dear Summoner,</span><br /><br />

This is a password reset email. Below is a link to continue your password reset.
If you have not requested this password reset you can ignore the email.
<br>
<br>
  <center>
  <br>
  <a href="http://www.nopex.net/account/login/reset-password/?email='.$email.'&resetcode='.$code.'"
  style=" color: white; background-color: #2B6CA3; padding: 5px; padding-left: 10px; padding-right: 10px;">Reset Password</a></center>
    <br><br>
    <span style="font-size: 14px; ">
      If the button does not work, copy this into the address bar of your browser:
      <a href="http://www.nopex.net/account/login/reset-password/?email='.$email.'&resetcode='.$code.'">http://www.nopex.net/account/login/reset-password/?email='.$email.'&resetcode='.$code.'</a>
    </span>
</div>

<div style="font-family: Oswald; background-color: #2B6CA3; color: white; padding: 10px; margin-top: 15px;">
<span>Website: <a style="color: white;" href="http://www.nopex.net">www.nopex.net</a> &nbsp;&bull;&nbsp
  Contact: <span style="color: white;">tanostro@web.de</span>

  <span style="float: right;">&copy; 2017-2018 nopex.net</span></span>
</div>
</div>
</div>
</body>';
?>
