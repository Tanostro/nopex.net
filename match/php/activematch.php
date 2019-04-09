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
    <?php if (isset($_COOKIE["darkmode"])){$cssmode = "dark"; $darkmode = "";} else { $cssmode = "light"; $darkmode = "settodarkmode";}
    echo '<link href="../source/css/main-'.$cssmode.'.css" rel="stylesheet" type="text/css">';
    echo '<link href="../source/css/match-'.$cssmode.'.css" rel="stylesheet" type="text/css">';?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
    <?php $SummonerName = str_replace(" ", "%20",$_GET['id']);?>
    <script>
      window.onload = function (){
      $('#matchboard').load("include/getmatch.php?region=<?php if (!empty($_GET['region'])){echo $_GET['region'];}?>&id=<?php echo $SummonerName;?>")
      }
    </script>

  </head>
  <body>
    <?php include $_SERVER["DOCUMENT_ROOT"]."/source/header/main.php"?>
    <div id="content">
      <div class="ad-vertical-left">
        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <!-- Wide Skyscraper -->
        <ins class="adsbygoogle"
             style="display:inline-block;width:160px;height:600px"
             data-ad-client="ca-pub-5342012939136550"
             data-ad-slot="8159306259"></ins>
        <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
      </div>
      <div class="ad-vertical-right">
        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <!-- Wide Skyscraper -->
        <ins class="adsbygoogle"
             style="display:inline-block;width:160px;height:600px"
             data-ad-client="ca-pub-5342012939136550"
             data-ad-slot="8159306259"></ins>
        <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
      </div>
      <div id="matchboard">
        <div id="loading">
          <div class="loader"></div>
          <p><?php echo $P_CONTENT["loading"];?>...</p>
        </div>
      </div>
      <div class="ad-horizontal">
        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <!-- horizontaler banner -->
        <ins class="adsbygoogle"
             style="display:inline-block;width:970px;height:90px"
             data-ad-client="ca-pub-5342012939136550"
             data-ad-slot="9805859602"></ins>
        <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
      </div>
    </div>
  </body>
</html>
