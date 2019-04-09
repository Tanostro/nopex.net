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
    $query = "SELECT rankedChampStats,champMasteries FROM $regionName WHERE sumId='$SummonerID'";
    foreach ($mysql->query($query) as $row);
    $row['rankedChampStats'] = mb_convert_encoding($row['rankedChampStats'], 'UTF-8', 'UTF-8');
    $ChampStats = json_decode($row['rankedChampStats'], true);
    $ChampStats = array_slice($ChampStats[1],1);
    $row['champMasteries'] = mb_convert_encoding($row['champMasteries'], 'UTF-8', 'UTF-8');
    $ChampMasteries = json_decode($row['champMasteries'], true);

}
if (!empty($_GET['type'])){
  if ($_GET['type'] == "ranked"){
    $Type = "Ranked Stats";
  } else if ($_GET['type'] == "mastery"){
    unset($ChampStats);
    $Type = "Champion Masteries";
  }
} else {
  if (!empty($ChampStats)){
    $Type = "Ranked Stats";
  } else {
    $Type = "Champion Masteries";
  }
}
if (!empty($_GET['sortType'])){
  if ($Type == "Champion Masteries"){
    if ($_GET['sortType'] == "masteryscore"){
      $sortType = "Masteryscore";
    }
    if ($_GET['sortType'] == "chest_available"){
      $sortType = "Chest available";
    }
  }
  if ($Type == "Ranked Stats"){
    if ($_GET['sortType'] == "winrate"){
      $sortType = "Winrate";
      foreach($ChampStats as $key => $array) {
          $sortArray[$key] = $array['winrate'];
      }
      array_multisort($sortArray, SORT_DESC, SORT_NUMERIC, $ChampStats);
      unset($sortArray);unset($array);
    }
    if ($_GET['sortType'] == "mostplayed"){
      $sortType = "Most Played";
      foreach($ChampStats as $key => $array) {
          $sortArray[$key] = $array['playedmatches'];
      }
      array_multisort($sortArray, SORT_DESC, SORT_NUMERIC, $ChampStats);
      unset($sortArray);unset($array);
    }
    if ($_GET['sortType'] == "kda"){
      $sortType = "KDA";
      foreach($ChampStats as $key => $array) {
          $sortArray[$key] = $array['kda'];
      }
      array_multisort($sortArray, SORT_DESC, SORT_NUMERIC, $ChampStats);
      unset($sortArray);unset($array);
    }
  }
} else {
  if ($Type == "Champion Masteries"){
    $sortType = "Masteryscore";
  }
  if ($Type == "Ranked Stats"){
    $sortType = "KDA";
    foreach($ChampStats as $key => $array) {
        $sortArray[$key] = $array['kda'];
    }
    array_multisort($sortArray, SORT_DESC, SORT_NUMERIC, $ChampStats);
    unset($sortArray);unset($array);
  }

}
?>
<link href="../source/css/light_summoner.css" rel="stylesheet" type="text/css">
<script>
function dropdown1() {
document.getElementById("drop-down-menu_1").classList.toggle("show");
}
function dropdown2() {
document.getElementById("drop-down-menu_2").classList.toggle("show");
}
function insertloading() {
  document.getElementById("championsbox").innerHTML = '<div style="width: 100%px; height: 300px; background-color: rgba(255,255,255,0.9);"><div class="lds-facebook" style="left: 500px; top: 100px;"><div></div><div></div><div></div></div></div>';
}
function Masteryscore() {
  insertloading();
  $('#championsbox').load("../summoner/champions.php?type=mastery&sortType=masteryscore&region=<?php echo $_GET['region'];?>&id=<?php echo $Summoner_name; ?>");
}
function ChestAvailable() {
  insertloading();
  $('#championsbox').load("../summoner/champions.php?type=mastery&sortType=chest_available&region=<?php echo $_GET['region'];?>&id=<?php echo $Summoner_name; ?>");
}
function KDA() {
  insertloading();
  $('#championsbox').load("../summoner/champions.php?type=ranked&sortType=kda&region=<?php echo $_GET['region'];?>&id=<?php echo $Summoner_name; ?>");
}
function Winrate() {
  insertloading();
  $('#championsbox').load("../summoner/champions.php?type=ranked&sortType=winrate&region=<?php echo $_GET['region'];?>&id=<?php echo $Summoner_name; ?>");
}
function MostPlayed() {
  insertloading();
  $('#championsbox').load("../summoner/champions.php?type=ranked&sortType=mostplayed&region=<?php echo $_GET['region'];?>&id=<?php echo $Summoner_name; ?>");
}
function ChampionMasteries() {
  insertloading();
  $('#championsbox').load("../summoner/champions.php?type=mastery&sortType=masteryscore&region=<?php echo $_GET['region'];?>&id=<?php echo $Summoner_name; ?>");
}
function RankedStats() {
  insertloading();
  $('#championsbox').load("../summoner/champions.php?type=ranked&sortType=kda&region=<?php echo $_GET['region'];?>&id=<?php echo $Summoner_name; ?>");
}
// Close the dropdown menu if the user clicks outside of it
window.onclick = function(event) {
if (!event.target.matches('.dropbtn')) {
  var dropdowns = document.getElementsByClassName("dropdown-content");
  var i;
  for (i = 0; i < dropdowns.length; i++) {
    var openDropdown = dropdowns[i];
    if (openDropdown.classList.contains('show')) {
      openDropdown.classList.remove('show');
    }
  }
}
}
</script>
      <?php
      echo'
      <div id="champion-sort-menu">
        <div class="dropdownframe">
        <button onclick="dropdown1()" id="drop-down-btn_1" class="dropbtn">'.$Type.' <span class="dropdownpfeil">^</span></button>
          <div id="drop-down-menu_1" class="dropdown-content">
            <button onclick="ChampionMasteries()" class="menubtn">Champion Masteries</button>
            <button onclick="RankedStats()" class="menubtn">Ranked Stats</button>
          </div>
        </div>

        <div class="dropdownframe">
        <button onclick="dropdown2()" class="dropbtn" id="drop-down-btn_2">sorted by: '.$sortType.' <span class="dropdownpfeil">^</span></button>
          <div id="drop-down-menu_2" class="dropdown-content">';
          if ($Type == "Champion Masteries"){
            echo'
              <button onclick="Masteryscore()" class="menubtn">Masteryscore</button>
              <button onclick="ChestAvailable()" class="menubtn">Chest available</button>
              ';
          }
          if ($Type == "Ranked Stats"){
            echo'
              <button onclick="KDA()" class="menubtn">KDA</button>
              <button onclick="Winrate()" class="menubtn">Winrate</button>
              <button onclick="MostPlayed()" class="menubtn">Most Played</button>
              ';
          }
          echo'</div>
        </div>
      </div>
      ';
      if (!empty($ChampStats)){
      $c=0;
      foreach ($ChampStats as $Champion) {
        $get_ChampionDB = "../source/loldata/championIds.json";
        $ChampionDB = json_decode(file_get_contents($get_ChampionDB), true);

        $championid = $Champion['id'];
      $SummonerChamp = $ChampionDB[$championid]['key'];
      $SummonerChamp = str_replace(" ", "",$SummonerChamp);
      $SummonerChamp = str_replace("'", "",$SummonerChamp);

      foreach ($ChampMasteries as $key => $val) {
          if ($val['championId'] == $championid) {
              $ChampionMastery = $ChampMasteries[$key];
          }
      }

      if(!empty($ChampionMastery['championLevel'])){$SummonerChampLvl = $ChampionMastery['championLevel'];} else { $SummonerChampLvl = "0";};
      $SummonerChampPoints = $ChampionMastery['championPoints'];
      $SumChampPoints = strlen($SummonerChampPoints);
      if(!empty($SummonerChampPoints)){$SummonerChampPointsNF = number_format($SummonerChampPoints);} else {$SummonerChampPointsNF = "0";}
      if ($SumChampPoints >= 7){$zl = "M"; $SummonerChampPoints = substr(number_format($SummonerChampPoints), 0, -6);};
      if ($SumChampPoints <7){$zl = "K"; $SummonerChampPoints = substr(number_format($SummonerChampPoints), 0, -4);};
      if ($SumChampPoints <= 3){$zl = ""; $SummonerChampPoints ="";};

      $wins = 0; $losses = 0;
      if(!empty($Champion['wins'])){$wins = $Champion['wins'];}
      if(!empty($Champion['losses'])){$losses = $Champion['losses'];}
      $ml = $wins + $losses;
      $winrate = round($Champion['winrate'],1);
      $dkill = round($Champion['kills'] / $ml, 1);
      $ddeath = round($Champion['deaths'] / $ml, 1);
      $dassist = round($Champion['assists'] / $ml, 1);

      echo '<div class="championbox">
      <div class="championplace"><span>'; echo $c+1; echo'.</span></div>
      <div style="margin-left: 60px; display: inline-block; padding: 5px;">
      <div style="margin-left: 5px; width: 55px;">
      <img class="champig" width="50px" src="https://ddragon.leagueoflegends.com/cdn/'.$LiveVersion.'/img/champion/'.$SummonerChamp.'.png" style="z-index: 1;"/>
      <img title="'; echo $SummonerChampPointsNF; echo' MasteryPoints" style=" margin-left: -5px; margin-top: -65px; z-index: 2; " width="32px;"src="/source/img/ChampMastery/Champ_Mastery_Lvl_';
      echo $SummonerChampLvl; echo'.png"</img>
      <div title="'; echo $SummonerChampPointsNF; echo' MasteryPoints"
      class="masterypoints">'; echo $SummonerChampPoints; echo'
      <span style="font-size: 10px;">'; echo $zl; echo'</span></div>
      </div>
      <div style="text-align: center; width: 100px; height: 50px; float: left;margin-top: -34px;margin-left: 80px;" title="K/D/A">
      <span style="font-size: 12px;">'; echo round($Champion['kda'],1); echo ' K/D/A</span><br>
      '; echo $dkill; echo ' / '; echo $ddeath; echo ' / '; echo $dassist; echo'
      </div>
      <div style="text-align: center; width: 50px;height: 50px; float: right; margin-top: -34px; margin-left: 20px;" title="Winrate">
      '; echo $winrate; echo' %<br>
      <span style="font-size: 12px;"><span style="color: #06CC06;">'; echo $wins; echo'</span> /
      <span style="color: #F22222;">'; echo $losses; echo'</span>
      </span>
      </div></div></div>';
            $c ++;
        }
  } else {
      $c=0;
      foreach ($ChampMasteries as $Champion) {
        $get_ChampionDB = "../source/loldata/championIds.json";
        $ChampionDB = json_decode(file_get_contents($get_ChampionDB), true);

        $championid = $Champion['championId'];
      $SummonerChamp = $ChampionDB[$championid]['key'];
      $SummonerChamp = str_replace(" ", "",$SummonerChamp);
      $SummonerChamp = str_replace("'", "",$SummonerChamp);

      $SummonerChampLvl = $Champion['championLevel'];
      $SummonerChampPoints = $Champion['championPoints'];
      $SumChampPoints = strlen($SummonerChampPoints);
      if(!empty($SummonerChampPoints)){$SummonerChampPointsNF = number_format($SummonerChampPoints);} else {$SummonerChampPointsNF = "0";}
      if ($SumChampPoints >= 7){$zl = "M"; $SummonerChampPoints = substr(number_format($SummonerChampPoints), 0, -6);};
      if ($SumChampPoints <7){$zl = "K"; $SummonerChampPoints = substr(number_format($SummonerChampPoints), 0, -4);};
      if ($SumChampPoints <= 3){$zl = ""; $SummonerChampPoints ="";};

      if (!empty($Champion['lastPlayTime'])){
        $agoUpdated = time() - round($Champion['lastPlayTime']/1000);
        $tag  = floor($agoUpdated / (3600*24));
        $std  = floor($agoUpdated / 3600 % 24);
        $min  = floor($agoUpdated / 60 % 60);
        $sek  = floor($agoUpdated % 60);

        $agoUpdated = "$tag day(s) $std hour(s) $min min $sek s";

        if ($tag !=0){ $roundAgo = "$tag day(s)";} else if ($std !=0){ $roundAgo = "$std hour(s)";} else if ($min !=0){ $roundAgo = "$min min";} else if ($sek !=0){ $roundAgo = "$sek s";}
      }
      if (($_GET['sortType'] == "chest_available") AND ($Champion['chestGranted'] == true)){
        $dontshow = true;
      } else
      {$dontshow = false;}
      if ($dontshow != true){
      echo '<div class="championbox">
      <div class="championplace"><span>'; echo $c+1; echo'.</span></div>
      <div style="margin-left: 60px; display: inline-block; padding: 5px;">
      <div style="margin-left: 5px; width: 55px;">
      <img class="champig" width="50px" src="https://ddragon.leagueoflegends.com/cdn/'.$LiveVersion.'/img/champion/'.$SummonerChamp.'.png" style="z-index: 1;"/>
      <img title="'; echo $SummonerChampPointsNF; echo' MasteryPoints" style=" margin-left: -5px; margin-top: -65px; z-index: 2; " width="32px;"src="/source/img/ChampMastery/Champ_Mastery_Lvl_';
      echo $SummonerChampLvl; echo'.png"</img>
      <div title="'; echo $SummonerChampPointsNF; echo' MasteryPoints"
      class="masterypoints">'; echo $SummonerChampPoints; echo'
      <span style="font-size: 10px;">'; echo $zl; echo'</span></div>
      </div></div>';
      if ($_GET['sortType'] == "chest_available"){
        echo'<div style="text-align: center; width: 200px; float: right; height: 50px; margin-top: 25px;margin-right: 10px;" title="K/D/A">
        Chest available';
      } else {
        echo'<div style="text-align: center; width: 200px; float: right; height: 50px; margin-top: 15px;margin-right: 10px;" title="K/D/A">
        '; echo $SummonerChampPointsNF; echo' Points<br>
        <span title="'; echo $agoUpdated; echo'"> Last Played: '; echo $roundAgo; echo' ago</span>';
      }
      echo'</div></div></div>';
          $c ++;
        }
      }
      echo'
      </div>
      </div>
    </div>';
    }
