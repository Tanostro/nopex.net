<?php
include "./source/php/main.php";
 ?>
<html>
  <head>
    <title>Nopex.net</title>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="./source/img/icons/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <?php if (isset($_COOKIE["darkmode"])){$cssmode = "dark"; $darkmode = "";} else { $cssmode = "light"; $darkmode = "settodarkmode";}
    echo '<link href="./source/css/main-'.$cssmode.'.css" rel="stylesheet" type="text/css">';?>
  </head>
  <body>
    <?php include "./source/header/main.php"?>

    <div style="background-color: var(--main-box-bg-color); box-shadow: 0px 4px 8px 0px rgba(0,0,0,0.2);
    width: 400px; margin: 50px auto 0 auto; padding: 25px;">
      <h1 style="color: #2B6CA3; margin-top: 0;">Update</h1>
      <div style="padding: 0 25px 0 25px;">
      Due to an update of the League of Legends API, we were forced to publish a version of the site
      that was not ready for release.<br>
      Accordingly, the statistics page is missing which has been extended by many options.
      The German language is e.g. not supported on all pages, as well as the dark mode.
      Summoner profiles
      had to be built from an old version with the capabilities of the new API.<br>
      This will be brought up to
      date as quickly as possible. And it adds the dark mode and the German language support.
      Then follow the statistics page, which we can hopefully restore by the end of February.
      So we can finally work on the actually planned updates. We take it easy and we hope so too.
      We are also looking forward to presenting you our new features (even if it is a long way to go).
      <br>
      We wish you much fun and luck in your placement games.<br><br>
      <div style="text-align: right;">Tanostro</div></div>
    </div>
  </body>
</html>
