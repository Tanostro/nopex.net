<?php
include $_SERVER["DOCUMENT_ROOT"]."/source/php/api.php";
if (!empty($_COOKIE["region"])){$Region = $_COOKIE["region"];} else {$Region = "euw1";}
$featuredMatches = apicall('featured_matches',$Region,0,0);
$Map = json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"]."/source/loldata/maps.json"), true);
$gameModes = json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"]."/source/loldata/queuetypes.json"), true);
$championDB = json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"]."/source/loldata/championIds.json"), true);
$LiveVersion = apicall("liveversion",0,0,0)[0];
$spellDB = json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"]."/source/loldata/summonerSpells.json"), true);

echo'
<div class="featured-matches">
  ';
  foreach ($featuredMatches["gameList"] as $Match) {
    $playerCount = count($Match["participants"]);
    echo '<div class="match">
      <div class="head">
      '.$Map[$Match["mapId"]].' - '.$gameModes[$Match["gameQueueConfigId"]]["Gamemode"].'
      <a href="http://'.$_SERVER['HTTP_HOST'].'/match/?id='.$Match["participants"][0]['summonerName'].'">
        <div class="spectate-btn">Spectate</div></a>
      </div>
      <div class="bans">
    ';
    if (!empty($Match["bannedChampions"])){
      $midPart = '</div> BANS <div class="redTeam">';
      echo'
        <div class="blueTeam">';
        $b = 0;
        foreach ($Match["bannedChampions"] as $Bans) {
          if ($Bans["championId"] != -1){
            $champ = $championDB[$Bans["championId"]]['key'];
            $champ = 'https://ddragon.leagueoflegends.com/cdn/'.$LiveVersion.'/img/champion/'.$champ.'.png';
            echo '<img class="banPig" src="'.$champ.'" />';
          } else {
            echo'<div class="banPig"></div>';
          }
          $b ++;
          if ($b == $playerCount / 2){
            echo $midPart;
          }
        }
        echo'
      </div>
      ';
    }
    echo '</div>
    <div class="playerBoard"><div class="blueTeam">';
    $midPart = '</div><div class="vs">VS</div><div class="redTeam">';
    $s = 0;
    foreach ($Match["participants"] as $Sum) {
      $spell1 = $spellDB[$Sum['spell1Id']]["icon"];
      $spell2 = $spellDB[$Sum['spell2Id']]["icon"];
      $Champion = $championDB[$Sum['championId']]["key"];
      echo'<div class="Sum">
        <img class="sumIcon" src="https://ddragon.leagueoflegends.com/cdn/'.$LiveVersion.'/img/champion/'.$Champion.'.png" />
        <img class="spellIcon1" src="'.$spell1.'"/>
        <img class="spellIcon2" src="'.$spell2.'"/>
        <a href="http://'.$_SERVER['HTTP_HOST'].'/summoner/?id='.$Sum['summonerName'].'">
        <div>'.$Sum['summonerName'].'</div>
        </a>
      </div>';
      $s ++;
      if ($s == $playerCount / 2){
        echo $midPart;
      }
    }
    echo '</div></div></div>';
  }
  echo'
</div>
';
?>
