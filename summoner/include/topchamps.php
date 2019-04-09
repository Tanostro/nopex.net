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

    // ### LiveVersion ###
        $get_Version = "https://ddragon.leagueoflegends.com/api/versions.json";
        $Version = json_decode(file_get_contents($get_Version), true);
        $LiveVersion = $Version['0'];

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
    $query = "SELECT rankedChampStats FROM $regionName WHERE sumId='$SummonerID'";
    foreach ($mysql->query($query) as $row);
    //$row['rankedChampStats'] = mb_convert_encoding($row['rankedChampStats'], 'UTF-8', 'UTF-8');
    $RanksCache = json_decode($row['rankedChampStats'], true);
    if (empty($RanksCache)){

      die ($diemsg);
      $query = "SELECT champMasteries FROM $regionName WHERE sumId='$SummonerID'";
      foreach ($mysql->query($query) as $row);
      $RanksCache = json_decode($row['champMasteries'], true);
      $headtext = "Top 6 - Mastery Champions";
    } else {
      $RanksCache = $RanksCache[1];
      $headtext = "Top 6 - Ranked Season 8";
    }
}

echo '
<div class="headbox" style="margin-bottom: 10px; text-align: center; text-shadow: none;"><span>'.$headtext.'</span></div>';


foreach($RanksCache as $key => $array) {
    $sortArray[$key] = $array['kills'];
}
array_multisort($sortArray, SORT_DESC, SORT_NUMERIC, $RanksCache);

//#####
unset($ChampionCache);unset($sortArray);unset($array);

$ChampionCache= $RanksCache;
$c = 0;
$RanksCache = array_slice($RanksCache,1);
foreach ($RanksCache as $row) {
$get_ChampionDB = "../source/loldata/championIds.json";
$ChampionDB = json_decode(file_get_contents($get_ChampionDB), true);

if (empty($row)){break;}
$championid = $row['id'];
$SummonerChamp = $ChampionDB[$championid]['key'];
$SummonerChamp = str_replace(" ", "",$SummonerChamp);
$SummonerChamp = str_replace("'", "",$SummonerChamp);

$get_ChampionMastery = "https://$region.api.riotgames.com/lol/champion-mastery/v4/champion-masteries/by-summoner/$SummonerID/by-champion/$championid?api_key=$API_KEY";
$ChampionMastery = json_decode(file_get_contents($get_ChampionMastery), true);

if(!empty($ChampionMastery['championLevel'])){$SummonerChampLvl = $ChampionMastery['championLevel'];} else { $SummonerChampLvl = "0";};
$SummonerChampPoints = $ChampionMastery['championPoints'];
$SumChampPoints = strlen($SummonerChampPoints);
if(!empty($SummonerChampPoints)){$SummonerChampPointsNF = number_format($SummonerChampPoints);} else {$SummonerChampPointsNF = "0";}
if ($SumChampPoints >= 7){$zl = "M"; $SummonerChampPoints = substr(number_format($SummonerChampPoints), 0, -6);};
if ($SumChampPoints <7){$zl = "K"; $SummonerChampPoints = substr(number_format($SummonerChampPoints), 0, -4);};
if ($SumChampPoints <= 3){$zl = ""; $SummonerChampPoints ="";};

$wins = 0; $losses = 0;
if(!empty($row['wins'])){$wins = $row['wins'];}
if(!empty($row['losses'])){$losses = $row['losses'];}
$ml = $wins + $losses;
$winrate = round($row['winrate'], 1);
$dkill = round($row['kills'] / $ml, 1);
$ddeath = round($row['deaths'] / $ml, 1);
$dassist = round($row['assists'] / $ml, 1);

      echo '
      <div style="margin-left: 5px; width: 55px;">
      <img class="champig" width="50px" src="https://ddragon.leagueoflegends.com/cdn/'.$LiveVersion.'/img/champion/'.$SummonerChamp.'.png" style="z-index: 1;"/>
      <img title="'; echo $SummonerChampPointsNF; echo' MasteryPoints" style=" margin-left: -5px; margin-top: -65px; z-index: 2; " width="32px;"src="/source/img/ChampMastery/Lvl_';
      echo $SummonerChampLvl; echo'.png"</img>
      <div title="'; echo $SummonerChampPointsNF; echo' MasteryPoints"
      class="masterypoints">'; echo $SummonerChampPoints; echo'
      <span style="font-size: 10px;">'; echo $zl; echo'</span></div>
      </div>
      <div style="text-align: center; width: 100px; height: 50px; float: left;margin-top: -50px;margin-left: 80px;" title="K/D/A">
      <span style="font-size: 12px;">'; echo round($row['kda'],1); echo ' K/D/A</span><br>
      '; echo $dkill; echo ' / '; echo $ddeath; echo ' / '; echo $dassist; echo'
      </div>
      <div style="text-align: center; width: 50px;height: 50px; float: right;margin-top: -50px;margin-right: 10px;" title="K/D/A">
      '; echo $winrate; echo' %<br>
      <span style="font-size: 12px;"><span style="color: #06CC06;">'; echo $wins; echo'</span> /
      <span style="color: #F22222;">'; echo $losses; echo'</span>
      </span>
      </div>
      <br>';
      if ($c >= 5){ break; }
      $c ++;
  }
?>
