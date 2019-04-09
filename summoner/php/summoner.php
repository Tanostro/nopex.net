<?php
include $_SERVER["DOCUMENT_ROOT"]."/source/php/main.php";

$P_CONTENT = json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"]."/match/lang/".$_COOKIE["lang"].".json"),true);

// ### MySQL ###
$mysqli = @new mysqli('############', '############', '############', '############');
  if ($mysql->connect_error) {
          die("Database connection error.");
        }
include $_SERVER["DOCUMENT_ROOT"]."/source/php/api.php";
$P_CONTENT = json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"]."/match/lang/".$_COOKIE["lang"].".json"),true);

$LiveVersion = apicall("liveversion",0,0,0)[0];
$regions = json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"]."/source/loldata/regions.json"), true);
if (empty($_GET['region'])){
  $Region = strtoupper($_COOKIE['region']);
} else {
  $Region = strtoupper($_GET['region']);
  foreach ($regions as $row) {
    if (strtoupper($_GET['region']) == $row["name"]){
      $Region = strtoupper($row['id']);
      break;
    }
  }
}
$SummonerName = str_replace(" ", "%20",$_GET['id']);
$Summoner = apicall('summoner_by_name',$Region,$SummonerName,0);
if (empty($Summoner)){ $errormsg = '
  <div id="errorbox">
  <p>'.$P_CONTENT["t_sum_not_found"].'</p>
  '.sprintf($P_CONTENT["sum_not_found"], $_GET['id']).'
  </div>
  ';}
  $SummonerId = $Summoner['id'];
  $SummonerName = $Summoner['name'];
  $SummonerIconId = $Summoner['profileIconId'];
  $SummonerLevel = $Summoner['summonerLevel'];
  $SummonerAccId = $Summoner['accountId'];
  // ALTE VARIABLEN
  $sum_name = $_GET['id'];
  $region = $Region;
  $SummonerID = $SummonerId;
?>
<html>
  <head>
    <title>Nopex.net</title>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="../source/img/icons/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <?php if (isset($_COOKIE["darkmode"])){$cssmode = "dark"; $darkmode = "";} else { $cssmode = "light"; $darkmode = "settodarkmode";}
    echo '<link href="../source/css/main-'.$cssmode.'.css" rel="stylesheet" type="text/css">';
    echo '<link href="../source/css/summoner-'.$cssmode.'.css" rel="stylesheet" type="text/css">';?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
    <script>
          window.onload = function (){
            $('#livematch_box').load("../match/livecheck.php?region=<?php echo $region;?>&id=<?php echo $SummonerID;?>&summoner=<?php echo $SummonerName;?>")
          }
          function updateSum(){
          document.getElementById("reload_sub").disabled = true;
          document.getElementById("updatefont").innerHTML = "Updating ...";
          var connection = new WebSocket('wss://www.nopex.net:7070');
          connection.onopen = function () {
            connection.send('Request Update'); // Send the message 'Ping' to the server
          };
          connection.onmessage = function (e) {
            console.log('Server: ' + e.data);
            switch(e.data) {
              case "Waiting_for_Information":
                connection.send('{"SumId":"<?php echo $SummonerID;?>","region":"<?php $regionName = strtoupper($region); echo $regionName;?>"}');
                break;
              case "finished":
                document.getElementById("reload_sub").disabled = false;
                document.getElementById("updatefont").innerHTML = "Profile is up to date";
                break;
              case "update_ranked_matches":
                $('#summonerchamps').load("/include/topchamps.php?region=<?php echo $Region;?>&id=<?php echo $SummonerName;?>", function(){
                })
                break;
              case "update_recent_matches":
                $('#matchlist').load("/include/recentmatches.php?region=<?php echo $Region;?>&id=<?php echo $SummonerName;?>", function(){
                })
                $('#match_historybox').load("/include/matchhistory.php?region=<?php echo $Region;?>&id=<?php echo $SummonerName;?>", function(){
                })
                break;
              case "update_champion_masteries":
                $('#championsbox').load("/include/champions.php?region=<?php echo $Region;?>&id=<?php echo $SummonerName;?>", function(){
                })
                break;
              case "update_ranked_leagues":
                $('#leaguebox').load("/include/leagues.php?region=<?php echo $Region;?>&id=<?php echo $SummonerName;?>", function(){
                })
                break;
              default:
                document.getElementById("updatefont").innerHTML = e.data;
            }
          };
          setTimeout(function () {
            if (connection.readyState != 1) {
              document.getElementById("updatefont").innerHTML = "Can't connect to Update Server. Please try again later.";
            }
          }, 1000);
        };
        </script>
  </head>
  <body>
    <?php include $_SERVER["DOCUMENT_ROOT"]."/source/header/main.php";?>
    <div id="content">


      <div style="margin: 25px auto 0 auto; background-color: rgba(255,165,0,0.7); color: white; width: 720px;
      padding: 10px; ">

      Currently no Dark Mode and the German language are supported. The Champions tab is disabled.
      </div>


      <?php
        if (isset($errormsg)){echo $errormsg;} else {
        $query = "SELECT * FROM $Region WHERE sumId='$SummonerId' ";
        $result = $mysql->query($query);
        $count = mysqli_num_rows($result);
        if ($count > 0){
          include $_SERVER["DOCUMENT_ROOT"]."/summoner/php/sum-found.php";
        } else {
          include $_SERVER["DOCUMENT_ROOT"]."/summoner/php/sum-not-found.php";
        }
      }
      ?>
    </div>
  </body>
</html>
