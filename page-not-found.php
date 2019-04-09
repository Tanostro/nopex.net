<html lang="de">
  <head>
    <title>Nopex.net</title>
    <meta charset="utf-8">
		<link href='https://fonts.googleapis.com/css?family=Oswald:400,700|Passion+One|Bangers|Chewy|Russo+One|Fredoka+One' rel='stylesheet' type='text/css'>
		<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
		<link rel="icon" href="../favicon.ico" type="image/x-icon">
    <?php if (isset($_COOKIE['darktheme'])){
      echo'<link href="../css/darktheme.css" rel="stylesheet" type="text/css">';
    } else {
      echo'<link href="../css/lighttheme.css" rel="stylesheet" type="text/css">';
    }?>
    <style>
    #footer { position: absolute; bottom: 20;}
    </style>
  </head>

  <body style="background-image: url(/img/Map/SR.jpg); background-repeat: no-repeat; background-attachment: fixed; background-position: center; background-size: cover;">

  <?php
  // ### header ###
  include 'noAccess/header.php';
  ?>
  <div id="error404Box">
    <img src="/img/icons/404.png" width="300px" style="margin-left: -30px;"/>
    <div style="position: relative; left: 20px; top: -40px; font-size: 20px; text-shadow: none; color: #F22222;">Page not Found.
    <br/><br/>
    <a style="font-size: 16px; color: #2B6CA3;"
    href="http://<?php echo $_SERVER['HTTP_HOST']; ?>">back to Homepage</a></div>
    <img src="/img/icons/jhin.png" width="100px" style="position: relative; right: -230px; top: -175px;"/>
  </div>
  <?php include 'noAccess/footer.php'; ?>

  </body>
