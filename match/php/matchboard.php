<?php
if (!empty($_GET["id"])){
  $cookieContent = array();
  $regionName = $regions[$_COOKIE["region"]]["name"];
  if (!empty($_COOKIE["SumSearches".$regionName])){ $cookieContent = json_decode($_COOKIE["SumSearches".$regionName]);}
  if (!in_array($_GET["id"], $cookieContent)){
  array_push($cookieContent, $_GET["id"]);
  setcookie("SumSearches".$regionName, json_encode($cookieContent), time()+315360000, '/', NULL, 0);}
}
$map = json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"]."/source/loldata/maps.json"), true)[$Match["mapId"]];
$mode = json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"]."/source/loldata/queuetypes.json"), true)[$Match["gameQueueConfigId"]]["Gamemode"];

$championDB = json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"]."/source/loldata/championIds.json"), true);
$spellDB = json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"]."/source/loldata/summonerSpells.json"), true);
$runeDB = json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"]."/source/loldata/rune.json"), true);

$playerCount = count($Match["participants"]);
if ($playerCount == 6){
  $matchboardClass = "sixplayer";
} else {
  $matchboardClass = "tenplayer";
}
if ($playerCount == 5){$playerCount = $playerCount*2;}
echo '<div id="matchboard" class="'.$matchboardClass.'">
        <div class="header">
        '.$map.' - '.$mode.'
        </div>
        <div>
      </div>';

$i = 0;
foreach ($Match["participants"] as $Sum) {
  $name = htmlentities($Sum['summonerName']);
  $icon = 'https://ddragon.leagueoflegends.com/cdn/'.$LiveVersion.'/img/profileicon/'.$Sum['profileIconId'].'.png';
  $champ = $championDB[$Sum["championId"]]['key'];
  $champ = "https://ddragon.leagueoflegends.com/cdn/img/champion/loading/".$champ."_0.jpg";
  if (empty($Sum["MasteryLevel"]['championLevel'])){$Sum["MasteryLevel"]['championLevel'] = 0;}
  if (empty($Sum["MasteryLevel"]['championPoints'])){$Sum["MasteryLevel"]['championPoints'] = 0;}
  $len = strlen($Sum["MasteryLevel"]['championPoints']);
  if ($len >= 7){
    $abk = "M";
    $shortMasteryPoints = substr(number_format($Sum["MasteryLevel"]['championPoints']), 0, -6);
  } else
  if ($len < 7 AND $len > 3){
    $abk = "K";
    $shortMasteryPoints = substr(number_format($Sum["MasteryLevel"]['championPoints']), 0, -4);
  } else {
    $abk = "";
    $shortMasteryPoints = number_format($Sum["MasteryLevel"]['championPoints']);
  }
  $shortMasteryPoints = $shortMasteryPoints." ".$abk;
  $spell1 = $spellDB[$Sum['spell1Id']]["icon"];
  $spell2 = $spellDB[$Sum['spell2Id']]["icon"];

  if($Sum['teamId'] == 100){$Team = 'BlueTeam';
  } else
  if($Sum['teamId'] == 200){$Team = 'RedTeam';
  } else { $Team = 'UnsetTeam';};

$LeagueF5_Tier = $LeagueF3_Tier = $LeagueSD_Tier = "unranked";
$LeagueF5_Rank = $LeagueF3_Rank = $LeagueSD_Rank = "&nbsp;";
$LeagueF3_Winrate = $LeagueSD_Winrate = $LeagueF5_Winrate = "&nbsp;";

foreach($Sum["rankedStats"] as $Rank){

    if((!empty($Rank['tier'])) AND (!empty($Rank['rank']))){
      $LeagueTier = strtolower($Rank['tier']);
      $LeagueRank = $Rank['rank'];
      $LeagueWins = $Rank['wins'];
      $LeagueLosses = $Rank['losses'];
    if($Rank['queueType'] == "RANKED_FLEX_SR"){
        $LeagueF5_Tier = $LeagueTier; $LeagueF5_Rank = $LeagueRank;
        $LeagueF5_Winrate = '<span class="wins">'.$LeagueWins.'</span> / <span class="losses">'.$LeagueLosses.'</span>';
      }
    if($Rank['queueType'] == "RANKED_SOLO_5x5"){
        $LeagueSD_Tier = $LeagueTier; $LeagueSD_Rank = $LeagueRank;
        $LeagueSD_Winrate = '<span class="wins">'.$LeagueWins.'</span> / <span class="losses">'.$LeagueLosses.'</span>';
      }
    if($Rank['queueType'] == "RANKED_FLEX_TT"){
        $LeagueF3_Tier = $LeagueTier; $LeagueF3_Rank = $LeagueRank;
        $LeagueF3_Winrate = '<span class="wins">'.$LeagueWins.'</span> / <span class="losses">'.$LeagueLosses.'</span>';
    }
    }
}

  echo '<div class="Summoner '.$Team.'" style="background-image: url(\''.$champ.'\');">
          <div class="head">
            <div class="left">
              <img src="'.$icon.'" class="sumIcon"/>
              <span class="sumlevel">'.$Sum['summonerLevel'].'</span>
            </div>
            <div class="sumName">'.$name.'</div>
            <div class="sumMastery">
              <img src="/source/img/ChampMastery/Lvl_'.$Sum["MasteryLevel"]['championLevel'].'.png"
              title="'.number_format($Sum["MasteryLevel"]['championPoints']).' Mastery Points" />
              <div title="'.number_format($Sum["MasteryLevel"]['championPoints']).' Mastery Points">
                '.$shortMasteryPoints.'
              </div>
            </div>
          </div>
          <div class="sumSpells">
            <img src="'.$spell1.'">
            <img src="'.$spell2.'">
          </div>
          <div class="bottom">
            <div class="ranks">
              <div title="'.ucfirst($LeagueF3_Tier)." ".$LeagueF3_Rank.'">
                <div>3v3</div>
                <img src="/source/img/tier/'.$LeagueF3_Tier.'.png"/>
                <div>'.$LeagueF3_Rank.'</div>
                <div title="Wins / Losses">'.$LeagueF3_Winrate.'</div>
              </div>
              <div title="'.ucfirst($LeagueSD_Tier)." ".$LeagueSD_Rank.'">
                <div>Solo/Duo</div>
                <img src="/source/img/tier/'.$LeagueSD_Tier.'.png"/>
                <div>'.$LeagueSD_Rank.'</div>
                <div title="Wins / Losses">'.$LeagueSD_Winrate.'</div>
              </div>
              <div title="'.ucfirst($LeagueF5_Tier)." ".$LeagueF5_Rank.'">
                <div>5v5</div>
                <img src="/source/img/tier/'.$LeagueF5_Tier.'.png"/>
                <div>'.$LeagueF5_Rank.'</div>
                <div title="Wins / Losses">'.$LeagueF5_Winrate.'</div>
              </div>
            </div>
            <div class="runes">
              <div class="firstPath">
                <img title="'.$runeDB[$Sum["perks"]["perkIds"][0]]["name"].'"
                src="../source/img/Runes/'.$Sum["perks"]["perkIds"][0].'.png"></img>
                <img title="'.$runeDB[$Sum["perks"]["perkIds"][1]]["name"].'"
                src="../source/img/Runes/'.$Sum["perks"]["perkIds"][1].'.png"></img>
                <img title="'.$runeDB[$Sum["perks"]["perkIds"][2]]["name"].'"
                src="../source/img/Runes/'.$Sum["perks"]["perkIds"][2].'.png"></img>
                <img title="'.$runeDB[$Sum["perks"]["perkIds"][3]]["name"].'"
                src="../source/img/Runes/'.$Sum["perks"]["perkIds"][3].'.png"></img>
              </div>
              <div class="secondPath">
                <img title="'.$runeDB[$Sum["perks"]["perkIds"][4]]["name"].'"
                src="../source/img/Runes/'.$Sum["perks"]["perkIds"][4].'.png"></img>
                <img title="'.$runeDB[$Sum["perks"]["perkIds"][5]]["name"].'"
                src="../source/img/Runes/'.$Sum["perks"]["perkIds"][5].'.png"></img>
              </div>
              <div class="statRunes">
                <img title="'.$runeDB[$Sum["perks"]["perkIds"][6]]["name"].'"
                src="../source/img/Runes/'.$Sum["perks"]["perkIds"][6].'.png"></img>
                <img title="'.$runeDB[$Sum["perks"]["perkIds"][7]]["name"].'"
                src="../source/img/Runes/'.$Sum["perks"]["perkIds"][7].'.png"></img>
                <img title="'.$runeDB[$Sum["perks"]["perkIds"][8]]["name"].'"
                src="../source/img/Runes/'.$Sum["perks"]["perkIds"][8].'.png"></img>
              </div>
            </div>
          </div>
        </div>';
        $i ++;
        if ($playerCount / 2  == $i){
          include $_SERVER["DOCUMENT_ROOT"]."/match/php/middle.php";
        }
}
echo ' <div class="foot">League of Legends Version: '.substr($LiveVersion, 0, -2).'</div>
      </div>
      ';
?>
