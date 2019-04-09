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
$LeagueSD_Tier = "unranked";
$LeagueF5_Tier = "unranked";
$LeagueF3_Tier = "unranked";

$LeagueSD_Rank = "unranked";
$LeagueF5_Rank = "unranked";
$LeagueF3_Rank = "unranked";


foreach ($RanksCache as $row ) {
  if ($row["queueType"] == "RANKED_SOLO_5x5"){
    $LeagueSD_Tier = strtolower($row["tier"]);
    $LeagueSD_Rank = $row["rank"];
  }
  if ($row["queueType"]== "RANKED_FLEX_SR"){
    $LeagueF5_Tier = strtolower($row["tier"]);
    $LeagueF5_Rank = $row["rank"];
  }
  if ($row["queueType"]== "RANKED_FLEX_TT"){
    $LeagueF3_Tier = strtolower($row["tier"]);
    $LeagueF3_Rank = $row["rank"];
  }
}
echo'
<div class="ranklist">
  <div class="rank" style="margin-left: 22px;">
  <span><center>3v3</center><img class="rank_img" style="float:none;" width="50px;"src="/source/img/tier/';
    echo $LeagueF3_Tier;echo'.png"</img><span class="r">';
    if($LeagueF3_Rank == "unranked"){ $LeagueF3_Rank = "";};
    echo $LeagueF3_Rank; echo'</span></span>
  </div>
  <div class="rank" style="margin-top: -15px; margin-left: 21px; width: 75px;">
  <span><center>Solo/Duo</center><img class="rank_img" style="margin-top: -8px; float:none;" width="75px;"src="/source/img/tier/';
    echo $LeagueSD_Tier;echo'.png"</img><span class="r" style="margin-right: 10px; margin-top: -20px; font-size: 20px; ">';
    if($LeagueSD_Rank == "unranked"){ $LeagueSD_Rank = "";};
    echo $LeagueSD_Rank; echo'</span></span>
  </div>
  <div class="rank" style="float: right;margin-right: 22px;">
  <span><center>5v5</center><img class="rank_img" style="float:none;" width="50px;"src="/source/img/tier/';
    echo $LeagueF5_Tier;echo'.png"</img><span class="r">';
    if($LeagueF5_Rank == "unranked"){ $LeagueF5_Rank = "";};
    echo $LeagueF5_Rank; echo'</span></span>
  </div>
</div>';
?>
