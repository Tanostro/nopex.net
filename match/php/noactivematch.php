<?php
include $_SERVER["DOCUMENT_ROOT"]."/source/php/main.php";
 ?>
<html>
  <head>
    <title>Nopex.net</title>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="../source/img/icons/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <?php if (isset($_COOKIE["darkmode"])){$cssmode = "dark"; $darkmode = "";} else { $cssmode = "light"; $darkmode = "settodarkmode";}
    echo '<link href="../source/css/main-'.$cssmode.'.css" rel="stylesheet" type="text/css">';
    echo '<link href="../source/css/match-'.$cssmode.'.css" rel="stylesheet" type="text/css">';?>
  </head>
  <body>
    <?php include $_SERVER["DOCUMENT_ROOT"]."/source/header/main.php"?>
    <div id="content">
    <?php include $_SERVER["DOCUMENT_ROOT"]."/match/php/featured-matches.php"?>
  </div>
  </body>
</html>
