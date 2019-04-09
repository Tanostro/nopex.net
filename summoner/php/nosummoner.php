<?php
include $_SERVER["DOCUMENT_ROOT"]."/source/php/main.php";

$P_CONTENT = json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"]."/match/lang/".$_COOKIE["lang"].".json"),true);
 ?>
<html>
  <head>
    <title>Nopex.net</title>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="../source/img/icons/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <link href="../source/css/main-light.css" rel="stylesheet" type="text/css">
    <link href="../source/css/summoner-light.css" rel="stylesheet" type="text/css">
  </head>
  <body>
    <?php
      include $_SERVER["DOCUMENT_ROOT"]."/source/header/main.php";
    ?>
    <div id="content">
    <?php
      include $_SERVER["DOCUMENT_ROOT"]."/summoner/php/topleagues.php";
      topleagues("challengerleagues","challenger");
      topleagues("grandmasterleagues","grandmaster");
      topleagues("masterleagues","master");
    ?>
  </div>
  </body>
<html>
