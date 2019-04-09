<?php if (isset($_COOKIE['darktheme'])){
  echo'<link href="../source/css/darktheme.css" rel="stylesheet" type="text/css">
  <link href="../source/css/dark_summoner.css" rel="stylesheet" type="text/css">';
} else {
  echo'<link href="../source/css/lighttheme.css" rel="stylesheet" type="text/css">
  <link href="../source/css/light_summoner.css" rel="stylesheet" type="text/css">';
}?>
<?php
$diemsg = '<div style="padding: 5px; text-align: center; color: #3484c1;
          margin-top: 40px;"> no data</div>';
// ### API key ###
$API_KEY="RGAPI-b04f4272-1938-4b95-96f3-ea86883193de";

if (empty($sum_name)){
    $mysqli = @new mysqli('############', '############', '############', '############');
    if ($mysql->connect_error) {
            die("Database connection error.");
          }
    // ### SUMMONERNAME ###
    $Summoner_name = str_replace(" ", "%20",$_GET['id']);
    $sum_name = $_GET['id'];

    // ### REGION ###
    if (empty($_GET['region'])){
      die ($diemsg);
    }
      else {
        if ($_GET['region'] == "euw"){ $region = "euw1";$regionId = 1;};
        if ($_GET['region'] == "eun"){ $region = "eun1";$regionId = 2;};
        if ($_GET['region'] == "na"){ $region = "na1";$regionId = 3;};
        if ($_GET['region'] == "br"){ $region = "br1";$regionId = 4;};
        if ($_GET['region'] == "jp"){ $region = "jp1";$regionId = 5;};
        if ($_GET['region'] == "kr"){ $region = "kr";$regionId = 6;};
        if ($_GET['region'] == "lan"){ $region = "la1";$regionId = 7;};
        if ($_GET['region'] == "las"){ $region = "la2";$regionId = 8;};
        if ($_GET['region'] == "oc"){ $region = "oc1";$regionId = 9;};
        if ($_GET['region'] == "tr"){ $region = "tr1";$regionId = 10;};
        if ($_GET['region'] == "ru"){ $region = "ru";$regionId = 11;};
      }
      // ### SUMMONER PROFILE ###
      $get_Summoner = "https://$region.api.riotgames.com/lol/summoner/v4/summoners/by-name/$Summoner_name?api_key=$API_KEY";
      $Summoner = json_decode(file_get_contents($get_Summoner), true);
      if (empty($Summoner)){
        die ($diemsg);
      }
      $SummonerID = $Summoner['id'];
      $SummonerName = $Summoner['name'];
      $SummonerIconId = $Summoner['profileIconId'];
      $SummonerLevel = $Summoner['summonerLevel'];
      $SummonerAccId = $Summoner['accountId'];
    $regionName = strtoupper($region);
    $query = "SELECT leagues FROM $regionName WHERE sumId='$SummonerID'";
    foreach ($mysql->query($query) as $row);
    $row['leagues'] = mb_convert_encoding($row['leagues'], 'UTF-8', 'UTF-8');
    $RanksCache = json_decode($row['leagues'], true);

}
$LeagueF3_Tier = "unranked";
$LeagueF3_Rank = "unranked";
$LeagueSD_Tier = "unranked";
$LeagueSD_Rank = "unranked";
$LeagueF5_Tier = "unranked";
$LeagueF5_Rank = "unranked";

$WinsF3 =
$LossesF3 =
$WinsSD =
$LossesSD =
$WinsF5 =
$LossesF5 =
$LeagueSD =
$LeagueF3 =
$LeagueF5 =
$LeagueLP_SD =
$LeagueLP_F3 =
$LeagueLP_F5 ="";

    foreach ($RanksCache as $row ) {
      if ($row["queueType"] == "RANKED_SOLO_5x5"){
        $LeagueSD_Tier = strtolower($row["tier"]);
        $LeagueSD_Rank = $row["rank"];
        $WinsSD = $row['wins'];
        $LossesSD = $row['losses'];
        $LeagueSD = str_replace("?", "'",$row['leagueName']);
        $LeagueLP_SD = $row['leaguePoints'];
        $LeagueId_SD = $row['leagueId'];
        }
      if ($row["queueType"]== "RANKED_FLEX_SR"){
        $LeagueF5_Tier = strtolower($row["tier"]);
        $LeagueF5_Rank = $row["rank"];
        $WinsF5 = $row['wins'];
        $LossesF5 = $row['losses'];
        $LeagueF5 = str_replace("?", "'",$row['leagueName']);
        $LeagueLP_F5 = $row['leaguePoints'];
        $LeagueId_F5 = $row['leagueId'];
        }
      if ($row["queueType"]== "RANKED_FLEX_TT"){
        $LeagueF3_Tier = strtolower($row["tier"]);
        $LeagueF3_Rank = $row["rank"];
        $WinsF3 = $row['wins'];
        $LossesF3 = $row['losses'];
        $LeagueF3 = str_replace("?", "'",$row['leagueName']);
        $LeagueLP_F3 = $row['leaguePoints'];
        $LeagueId_F3 = $row['leagueId'];
        }
      }

      if (!empty($LeagueSD_Rank)){
        $preselection = 1;
      } else {
        if (!empty($LeagueF3_Rank)){
          $preselection = 2;
        } else {
          if (!empty($LeagueF5_Rank)){
            $preselection = 3;
          }
        }
      }

      echo '
      <div style="width: 1080px; margin:auto;">

      <input type="radio" class="leaguebtn" name="leaguemenu" id="F3" '; if ($preselection == 2){echo "checked";}; echo'/>
      <label for="F3" class="LeagueBox">
        <div style="margin-left: 15px; width: 60px; height: 100%;">
        <img class="rank_img" style="float:none;" width="60px;"src="/source/img/tier/';
        echo $LeagueF3_Tier;echo'.png"</img>
        <div class="ranktier">';
        if($LeagueF3_Rank == "unranked"){ $LeagueF3_Rank = "";};
        echo $LeagueF3_Rank; echo'</div>
        </div>
        <div class="rankinfo">
        <center>3v3 Flex<br>
        <span style="font-size: 18px;">
          <span style="color: #06cc06;" title="Wins">'; echo $WinsF3; echo'</span>
          '; if(!empty($WinsF3)){echo " / ";}; echo'
          <span title="Losses" style="color: #F22222;">'; echo $LossesF3; echo'</span>
          <br>'; echo $LeagueLP_F3; if(!empty($WinsF3)){echo " LP";}; echo'</span>
        </center>
        </div>
      </label>

      <input type="radio" class="leaguebtn" name="leaguemenu" id="SD"'; if ($preselection == 1){echo "checked";}; echo'/>
      <label for="SD" class="LeagueBox">
      <div style="margin-left: 15px; width: 60px; height: 100%;">
      <img class="rank_img" style="float:none;" width="60px;"src="/source/img/tier/';
        echo $LeagueSD_Tier;echo'.png"</img>
        <div class="ranktier">';
        if($LeagueSD_Rank == "unranked"){ $LeagueSD_Rank = "";};
        echo $LeagueSD_Rank; echo'</div>
      </div>
        <div class="rankinfo">
          <center>Solo/Duo<br>
          <span style="font-size: 18px;">
            <span style="color: #06cc06;" title="Wins">'; echo $WinsSD; echo'</span>
            '; if(!empty($WinsSD)){echo " / ";}; echo'
            <span title="Losses" style="color: #F22222;">'; echo $LossesSD; echo'</span>
            <br>'; echo $LeagueLP_SD; if(!empty($WinsSD)){echo " LP";}; echo'</span>
          </center>
        </div>
      </label>

      <input type="radio" class="leaguebtn" name="leaguemenu" id="F5"'; if ($preselection == 3){echo "checked";}; echo'/>
      <label for="F5" class="LeagueBox">
      <div style="margin-left: 15px; width: 60px; height: 100%;">
      <img class="rank_img" style="float:none;" width="60px;"src="/source/img/tier/';
        echo $LeagueF5_Tier;echo'.png"</img>
        <div class="ranktier">';
        if($LeagueF5_Rank == "unranked"){ $LeagueF5_Rank = "";};
        echo $LeagueF5_Rank; echo'</div>
      </div>
      <div class="rankinfo">
      <center>5v5 Flex<br>
      <span style="font-size: 18px;">
        <span style="color: #06cc06;" title="Wins">'; echo $WinsF5; echo'</span>
        '; if(!empty($WinsF5)){echo " / ";}; echo'
        <span title="Losses" style="color: #F22222;">'; echo $LossesF5; echo'</span>
        <br>'; echo $LeagueLP_F5; if(!empty($WinsF5)){echo " LP";}; echo'</span>
      </center>
      </div>
      </label>


      <div id="LeagueListF3">
      '; if (!empty($LeagueId_F3)){
      $LeagueID = $LeagueId_F3;
      $LS = "F3";$LeagueName = $LeagueF3;
      include ('getrankedleague.php');
    } else {
        echo '<div style="background-color: rgba(255,255,255,0.9); height: 300px; padding-top: 200px;
        font-size: 24px; color: #2B6CA3; text-shadow: none; text-align: center;">
          Summoner has no ranked matches in this queue...
        </div>';} echo'
      </div>

      <div id="LeagueListSD">
      '; if (!empty($LeagueId_SD)){
        $LeagueID = $LeagueId_SD;
        $LS = "SD";$LeagueName = $LeagueSD;
        include ('getrankedleague.php');
      }  else {
          echo '<div style="background-color: rgba(255,255,255,0.9); height: 300px; padding-top: 200px;
          font-size: 24px; color: #2B6CA3; text-shadow: none; text-align: center;">
            Summoner has no ranked matches in this queue...
          </div>';} echo'
      </div>

      <div id="LeagueListF5">
      '; if (!empty($LeagueId_F5)){
        $LeagueID = $LeagueId_F5;
        $LS = "F5";$LeagueName = $LeagueF5;
        include ('getrankedleague.php');
      }  else {
          echo '<div style="background-color: rgba(255,255,255,0.9); height: 300px; padding-top: 200px;
          font-size: 24px; color: #2B6CA3; text-shadow: none; text-align: center;">
            Summoner has no ranked matches in this queue...
          </div>';} echo'
      </div>
    </div>
      ';
?>
