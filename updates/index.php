<?php
include $_SERVER['DOCUMENT_ROOT']."/source/php/main.php";
 ?>
<html>
  <head>
    <title>Nopex.net</title>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="../source/img/icons/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <?php if (isset($_COOKIE["darkmode"])){$cssmode = "dark"; $darkmode = "";} else { $cssmode = "light"; $darkmode = "settodarkmode";}
    echo '<link href="../source/css/main-'.$cssmode.'.css" rel="stylesheet" type="text/css">';?>
  <style>
    .post {background-color: var(--main-box-bg-color); box-shadow: 0px 4px 8px 0px rgba(0,0,0,0.2);
       width: 400px; padding:15px; text-shadow: none; margin: auto; margin-top: 50px; }
    .headline { color: #2B6CA3; font-size: 24px; font-weight: 600; margin-bottom: 20px;}
    .content {font-size: 16px;}
  </style>
  </head>
  <body>
  <?php include $_SERVER['DOCUMENT_ROOT']."/source/header/main.php";?>

  <div class="post">
    <div class="headline">Update Notes for 12/12/2018</div>
    <div class="content">
      [CHEST_CHECK]<br>
      -removed ChestCheck<br>
      -is now included in Summoner > Champions > Champion Masteries > Chest available<br>
      <br>
      [SUMMONER]<br>
      -SummonerProfile renamed to Summoner<br>
      -addet Ranked (replaced League)<br>
      -addet ChampionStats wit new sort options<br>
      <br>
      [MISC]<br>
      - addet new color codes to the standart lighttheme<br>
    </div>
  </div>

  <div class="post">
    <div class="headline">Update Notes for 12/6/2018</div>
    <div class="content">
      [MISC]<br>
      -addet Ranked Remastered Icons<br>
      <br>
      [SUMMONER_PROFILES]<br>
      -new Update function with a dedicated Server<br>
      -new text nearby the update button shows the current update state <br>
      -increased update speed to about 3 times faster<br>
      -diabled Leagues (coming back soon)<br>
      -disabled ChampionStats (working on a new design including chestcheck and more)<br>
      <br>
      [INFO]<br>
      Statistics Alpha is working good so far. I'm doing my best to finish SummonerProfile, so i can continue
      my work to increase the amount of information per champion u can get out of the statistics.
      This includes sort functions for patch, ranks and mostplayed itembuilds and so on.
      I hope i will finish all in this year.
    </div>
  </div>

    <div class="post">
      <div class="headline">Update Notes for 11/21/2018</div>
      <div class="content">
        [MENU]<br>
        -addet new sidemenu<br>
        <br>
        [MISC]<br>
        -updated old source paths<br>
        -changed directory for all sources to /source directory<br>
        <br>
        [LIVE_MATCHES]<br>
        -addet blank page that displayes current live matches<br>
        -update alignment for Summoner Spells<br>
        -addet new Stat runes<br>
        -fixed Bug, that caused a wrong formatting<br>
        <br>
        [SUMMONER_PROFILES]<br>
        -addet blank page that displayes challenger players for the currently selected region<br>
        -new header background that displayes the highest mastery champ for the given players (currently not working)<br>
        -shrinked the old header menu to fit better<br>
        -removed blank spaces between single matches in the matchhistory<br>
      </div>
    </div>
  </body>
