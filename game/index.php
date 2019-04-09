<?php
if (empty($_GET['id'])){
  die(header('Location: http://' . $_SERVER['HTTP_HOST'] . ''));}
  $matchId = $_GET['id'];
if (empty($_GET['region'])){
  die(header('Location: http://' . $_SERVER['HTTP_HOST'] . ''));}
  else {
	$region = $_GET['region'];
    if ($_GET['region'] == "euw"){ $region = "euw1";$regionId = 1;};
    if ($_GET['region'] == "eun"){ $region = "eun1";$regionId = 2;};
    if ($_GET['region'] == "nq"){ $region = "na1";$regionId = 3;};
    if ($_GET['region'] == "br"){ $region = "br1";$regionId = 4;};
    if ($_GET['region'] == "jp"){ $region = "jp1";$regionId = 5;};
    if ($_GET['region'] == "kr"){ $region = "kr";$regionId = 6;};
    if ($_GET['region'] == "lan"){ $region = "la1";$regionId = 7;};
    if ($_GET['region'] == "las"){ $region = "la2";$regionId = 8;};
    if ($_GET['region'] == "oc"){ $region = "oc1";$regionId = 9;};
    if ($_GET['region'] == "tr"){ $region = "tr1";$regionId = 10;};
    if ($_GET['region'] == "ru"){ $region = "ru";$regionId = 11;};
  }
  $regionname = $_GET['region'];

  // ### SUMMONERNAME ###
  //$Summoner_name = str_replace(" ", "%20",$_GET['id']);
  //$sum_name = $_GET['id'];
  // ### API key ###
  $API_KEY="RGAPI-b04f4272-1938-4b95-96f3-ea86883193de";
  // ### MySQL ###
  //$mysqli = @new mysqli('############', '############', '############', '############');
  //  if ($mysql->connect_error) {
  //          die("Database connection error.");
  //       }
  // ### LiveVersion ###
      $get_Version = "https://ddragon.leagueoflegends.com/api/versions.json";
      $Version = json_decode(file_get_contents($get_Version), true);
      $LiveVersion = $Version['0'];

      $get_ChampionDB = "../source/loldata/championIds.json";
      $ChampionDB = json_decode(file_get_contents($get_ChampionDB), true);

      $get_queuetypes = "../source/loldata/queuetypes.json";
      $queuetypes = json_decode(file_get_contents($get_queuetypes), true);

      $get_SpellDB = "../source/loldata/SummonerSpells.json";
      $SpellDB = json_decode(file_get_contents($get_SpellDB), true);


      if (empty($Match)){
        $get_Match = "https://$region.api.riotgames.com/lol/match/v4/matches/$matchId?api_key=$API_KEY";
        $Match = json_decode(file_get_contents($get_Match), true);
        if (empty($Match)){ die(header('Location: http://' . $_SERVER['HTTP_HOST'] . ''));}
      } else {
        $Match['participants'] = json_decode($Match['participants'], true);
        $Match['participantIdentities'] = json_decode($Match['participantIdentities'], true);
      }

?>
<html lang="de">
  <head>
    <title>Nopex - Match</title>
    <meta charset="utf-8">
		<link href='https://fonts.googleapis.com/css?family=Oswald:400,700|Passion+One|Bangers|Chewy|Russo+One|Fredoka+One' rel='stylesheet' type='text/css'>
		<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
		<link rel="icon" href="/favicon.ico" type="image/x-icon">
    <?php if (isset($_COOKIE['darktheme'])){
      echo'<link href="../source/css/darktheme.css" rel="stylesheet" type="text/css">';
      echo'<link href="../source/css/dark_game.css" rel="stylesheet" type="text/css">';
    } else {
      echo'<link href="../source/css/lighttheme.css" rel="stylesheet" type="text/css">';
      echo'<link href="../source/css/light_game.css" rel="stylesheet" type="text/css">';
    }?>
    <style>
      p {margin: 0;}
      #header{min-width: 1080px;}
      #subheader{min-width: 1080px;}
      #footer{min-width: 1080px;}
      #cookieEU{  min-width: 1060px;}
    </style>
  </head>

<body style="background: url(/source/img/Map/SR_sw.jpg);
    background-repeat: no-repeat; background-attachment: fixed; background-position: center; background-size: cover;">

    <?php
    // ### header ###
  	include '../source/php/header.php';

    $gameId = $Match['gameId'];
    $queue = $Match['queueId'];
      $Gamemode = $queuetypes[$queue]['Gamemode'];
      $MapID = $queuetypes[$queue]['MapID'];
      if (!empty($MapID)){
        if($MapID==1){$Map = "Summoners Rift";}
        if($MapID==10){$Map = "Twisted Treeline";}
        if($MapID==11){$Map = "Summoners Rift";}
        if($MapID==12){$Map = "Howling Abyss";}
        }
      $timestamp = $Match['gameCreation'] / 1000;
      $date = date('m/d/Y', $timestamp);
      $duration = $Match['gameDuration'];
      $min  = floor($duration / 60 % 60);
      $sek  = floor($duration % 60);
      $time = $min.':'.$sek;

      $Team1_cs = 0;
      $Team1_gold = 0;
      $Team1_kills = 0;
      $Team1_deaths = 0;
      $Team1_assists = 0;
      $Team2_cs = 0;
      $Team2_gold = 0;
      $Team2_kills = 0;
      $Team2_deaths = 0;
      $Team2_assists = 0;
      $nop = $Match['participantIdentities'];
      $nop = count($nop);
      $i = 0;
      while($i < $nop){
      $cs = $Match['participants'][$i]['stats']['totalMinionsKilled'];
      $gold = $Match['participants'][$i]['stats']['goldEarned'];

      $kills = $Match['participants'][$i]['stats']['kills'];
      $deaths = $Match['participants'][$i]['stats']['deaths'];
      $assists = $Match['participants'][$i]['stats']['assists'];

      if ($i <= ($nop/2 -1)){
        $Team1_gold = $Team1_gold + $gold;
        $Team1_kills = $Team1_kills + $kills;
        $Team1_deaths = $Team1_deaths + $deaths;
        $Team1_assists = $Team1_assists + $assists;
        } else {
        $Team2_gold = $Team2_gold + $gold;
        $Team2_kills = $Team2_kills + $kills;
        $Team2_deaths = $Team2_deaths + $deaths;
        $Team2_assists = $Team2_assists + $assists;
        }
      $i ++;
    }
    $Team1kda = $Team1_kills." / ".$Team1_deaths." / ".$Team1_assists;
    $Team2kda = $Team2_kills." / ".$Team2_deaths." / ".$Team2_assists;
    echo'
    <div class="gamecontent">
      <div id="gameheadline">'.$Gamemode.' &bull; '.$Map.' &bull; '.$time.' &bull;  '.$date.'</div>
      <input class="tab" type="radio" name="menu" id="scoreboard" checked>
      <label for="scoreboard"><div>SCOREBOARD</div></label>
      <input class="tab" type="radio" name="menu" id="stats" >
      <label for="stats"><div>STATS</div></label>
      <div id="scoreboardcontent">
      ';

      echo '<div id="team1">
      <div id="team1stats">
      <div>';
      if ($Match['teams'][0]['win'] == "Win"){ echo "VICTORY";} else {echo "DEFEAT";}
      echo'</div>
      <div>Blue Team</div>
      <div>'.$Team1kda.'</div>
      <div>'.$Team1_gold.' gold</div>
      <div style="float: right;">';
      if (!empty($Match['teams'][0]['bans'])){
        $i=0;
        while($i<5){
        if ( $Match['teams'][0]['bans'][$i]['championId'] == -1){
          echo'<div class="bannedChampion" style="margin-right: 10px;"></div>';} else{
            $BannedChampId = $Match['teams'][0]['bans'][$i]['championId'];
            $BannedChampName = $ChampionDB[$BannedChampId]['key'];
          echo'<div class="bannedChampion" style="margin-right: 10px;">
          <img style="border-radius: 30%; filter: grayscale(1); -webkit-filter: grayscale(1);" width="24px" src="https://ddragon.leagueoflegends.com/cdn/'.$LiveVersion.'/img/champion/'.$BannedChampName.'.png" /></div>';
        }
        $i++;
        }
      }
      echo'</div>
      </div>
      ';
      $i = 0;
      while($i < $nop){
        $championid = $Match['participants'][$i]['championId'];
      $SummonerChampion = $ChampionDB[$championid]['key'];
        $SummonerChampion = str_replace(" ", "",$SummonerChampion);
        $SummonerChampion = str_replace("'", "",$SummonerChampion);
      $SummonerChamp[$i] = "https://ddragon.leagueoflegends.com/cdn/$LiveVersion/img/champion/$SummonerChampion.png";
      $ChampionLvl = $Match['participants'][$i]['stats']['champLevel'];
        $spell1 = $Match['participants'][$i]['spell1Id'];
      $Spell1 = $SpellDB['data'][$spell1]['icon'];
        $spell2 = $Match['participants'][$i]['spell2Id'];
      $Spell2 = $SpellDB['data'][$spell2]['icon'];

      $kills = $Match['participants'][$i]['stats']['kills'];
      $deaths = $Match['participants'][$i]['stats']['deaths'];
      $assists = $Match['participants'][$i]['stats']['assists'];

      $item1 = $Match['participants'][$i]['stats']['item0'];
      $item2 = $Match['participants'][$i]['stats']['item1'];
      $item3 = $Match['participants'][$i]['stats']['item2'];
      $item4 = $Match['participants'][$i]['stats']['item3'];
      $item5 = $Match['participants'][$i]['stats']['item4'];
      $item6 = $Match['participants'][$i]['stats']['item5'];
      $ward = $Match['participants'][$i]['stats']['item6'];

      $Rune1Pfad = $Match['participants'][$i]['stats']['perk0'];
      $Rune1KS = $Match['participants'][$i]['stats']['perk0'];
      $Rune1_1 = $Match['participants'][$i]['stats']['perk1'];
      $Rune1_2 = $Match['participants'][$i]['stats']['perk2'];
      $Rune1_3 = $Match['participants'][$i]['stats']['perk3'];
      $Rune2_1 = $Match['participants'][$i]['stats']['perk4'];
      $Rune2_2 = $Match['participants'][$i]['stats']['perk5'];

      $cs = $Match['participants'][$i]['stats']['totalMinionsKilled'];
      $gold = $Match['participants'][$i]['stats']['goldEarned'];
      $kda[$i] = "$kills / $deaths / $assists";

      $summonername = $Match['participantIdentities'][$i]['player']['summonerName'];

      echo '
      <div class="player">
      <div style="float: left;margin-right: 5px;">
        <img src="'; echo $Spell1; echo'" height="18px" style="float: none; margin-top: 1px;margin-bottom: 1px; border-radius: 30%;"></img><br>
        <img src="'; echo $Spell2; echo'" height="18px" style="float: none; margin-top: 1px;margin-bottom: 1px; border-radius: 30%;"></img>
      </div>
      <div style="float: left;">
        <img class"champpig" src="'.$SummonerChamp[$i].'" width="40px" style="z-index: 2; border-radius: 30%;"/>
        <div class="champlvl">'.$ChampionLvl.'</div>
      </div>
        <div class="playername"><a href="/summoner/?region='.$_GET['region'].'&id='.$summonername.'">'.$summonername.'</a></div>
        <div class="kda">'.$kda[$i].'</div>
        <div class="itembox">
        <div class="itemsquare">';  if (!empty($item1)){ echo '<img class="itempig" src="https://ddragon.leagueoflegends.com/cdn/'.$LiveVersion.'/img/item/'.$item1.'.png"></img>';} echo'</div>
        <div class="itemsquare">';  if (!empty($item2)){ echo '<img class="itempig" src="https://ddragon.leagueoflegends.com/cdn/'.$LiveVersion.'/img/item/'.$item2.'.png"></img>';} echo'</div>
        <div class="itemsquare">';  if (!empty($item3)){ echo '<img class="itempig" src="https://ddragon.leagueoflegends.com/cdn/'.$LiveVersion.'/img/item/'.$item3.'.png"></img>';} echo'</div>
        <div class="itemsquare">';  if (!empty($item4)){ echo '<img class="itempig" src="https://ddragon.leagueoflegends.com/cdn/'.$LiveVersion.'/img/item/'.$item4.'.png"></img>';} echo'</div>
        <div class="itemsquare">';  if (!empty($item5)){ echo '<img class="itempig" src="https://ddragon.leagueoflegends.com/cdn/'.$LiveVersion.'/img/item/'.$item5.'.png"></img>';} echo'</div>
        <div class="itemsquare">';  if (!empty($item6)){ echo '<img class="itempig" src="https://ddragon.leagueoflegends.com/cdn/'.$LiveVersion.'/img/item/'.$item6.'.png"></img>';} echo'</div>
        <div class="itemsquare">';  if (!empty($ward)){ echo '<img class="itempig" src="https://ddragon.leagueoflegends.com/cdn/'.$LiveVersion.'/img/item/'.$ward.'.png"></img>';} echo'</div>
        </div>
        <div class="runenbox">
        <div class="runensquare">';  if (!empty($Rune1KS)){ echo '<img class="runenpig" src="../source/img/Runes/'.$Rune1KS.'.png"></img>';} echo'</div>
        <div class="runensquare">';  if (!empty($Rune1_1)){ echo '<img class="runenpig" src="../source/img/Runes/'.$Rune1_1.'.png"></img>';} echo'</div>
        <div class="runensquare">';  if (!empty($Rune1_2)){ echo '<img class="runenpig" src="../source/img/Runes/'.$Rune1_2.'.png"></img>';} echo'</div>
        <div class="runensquare">';  if (!empty($Rune1_3)){ echo '<img class="runenpig" src="../source/img/Runes/'.$Rune1_3.'.png"></img>';} echo'</div>
        <div class="runensquare">';  if (!empty($Rune2_1)){ echo '<img class="runenpig" src="../source/img/Runes/'.$Rune2_1.'.png"></img>';} echo'</div>
        <div class="runensquare">';  if (!empty($Rune2_2)){ echo '<img class="runenpig" src="../source/img/Runes/'.$Rune2_2.'.png"></img>';} echo'</div>
        </div>

        <div class="cs">'.$cs.' cs</div>
        <div class="gold">'.$gold.' gold</div>
        </div>';

        if ($i == $nop/2 -1){ echo '</div><br><div id="team2">
          <div id="team2stats">
          <div>';
          if ($Match['teams'][1]['win'] == "Win"){ echo "VICTORY";} else {echo "DEFEAT";}
          echo'</div>
          <div>Red Team</div>
          <div>'.$Team2kda.'</div>
          <div>'.$Team2_gold.' gold</div>
          <div style="float: right;">';
          if (!empty($Match['teams'][1]['bans'])){
            $ci=0;
            while($ci<5){
            if ( $Match['teams'][1]['bans'][$ci]['championId'] == -1){
              echo'<div class="bannedChampion" style="margin-right: 10px;">

              </div>';} else{
                $BannedChampId = $Match['teams'][1]['bans'][$ci]['championId'];
                $BannedChampName = $ChampionDB[$BannedChampId]['key'];
              echo'<div class="bannedChampion" style="margin-right: 10px;">
              <img style="border-radius: 30%; filter: grayscale(1); -webkit-filter: grayscale(1);" width="24px" src="https://ddragon.leagueoflegends.com/cdn/'.$LiveVersion.'/img/champion/'.$BannedChampName.'.png" />
              </div>';
            }
            $ci++;
            }
          }
          echo'</div>
          </div>';}
        $i ++;
      }
      echo'
        </div>
      </div>
      <div id="statscontent">
        <div class="entry" id="statsheader" >
        <div class="entrywidth" style="">&nbsp;</div>';

        $i=0;
        while($i < $nop){
          echo'<div class="entrywidth" style="margin: 2px 2px 0px 2px; padding: 0px 0px 5px 0px;
          '; if ($i < $nop/2 -1) { echo'border-bottom: #2B6CA3 solid 2px;'; } else
          { echo'border-bottom: #B22222 solid 2px;'; } echo'
          "><img class"champpig" src="'.$SummonerChamp[$i].'" width="40px" style="z-index: 2; border-radius: 30%;"/></div>';
            $i++;
        }
        echo'</div>
        <input class="tabdwn" type="checkbox" name="dwn" id="tab1" checked/>
        <label for="tab1"><div>COMBAT</div></label>
        <div id="tab1content">
          <div class="entry">
            <div class="entrywidth">KDA</div>
            ';$i =0;
            while ($i < $nop){echo '<div class="entrywidth">'.$kda[$i].'</div>';
            $i++;}
            echo'
          </div>
          <div class="entry">
            <div class="entrywidth">Largest Killing Spree</div>
            ';$i =0; while ($i < $nop){
              echo '<div class="entrywidth">'.$Match['participants'][$i]['stats']['largestKillingSpree'].'</div>';
            $i++;}
            echo'
          </div>
          <div class="entry">
            <div class="entrywidth">Largest Multi Kill</div>
            ';$i =0; while ($i < $nop){
              echo '<div class="entrywidth">'.$Match['participants'][$i]['stats']['largestMultiKill'].'</div>';
            $i++;} echo'
          </div>
          <div class="entry">
            <div class="entrywidth">Crowd Control Score</div>
            ';$i =0; while ($i < $nop){
              echo '<div class="entrywidth">'.$Match['participants'][$i]['stats']['visionScore'].'</div>';
            $i++;} echo'
          </div>
          <div class="entry">
            <div class="entrywidth">First Blood</div>
            ';$i =0; while ($i < $nop){
              if ($Match['participants'][$i]['stats']['firstBloodKill'] == true)
              {$FirstBlood ='<div style="border-radius: 100%; background-color: #2B6CA3; width:  10px; height: 10px; "></div>';} else {$FirstBlood = "";}
              echo '<div class="entrywidth">'.$FirstBlood.'</div>';
            $i++;} echo'
          </div>
        </div>

        <input class="tabdwn" type="checkbox" name="dwn2" id="tab2" checked/>
        <label for="tab2"><div>DAMAGE DEALT</div></label>
        <div id="tab2content">
          <div class="entry">
            <div class="entrywidth">Total Damage to Champions</div>
            ';$i =0; while ($i < $nop){
              echo '<div class="entrywidth">'.$Match['participants'][$i]['stats']['totalDamageDealtToChampions'].'</div>';
            $i++;} echo'
          </div>
          <div class="entry">
            <div class="entrywidth">Physical Damage to Champions</div>
            ';$i =0; while ($i < $nop){
              echo '<div class="entrywidth">'.$Match['participants'][$i]['stats']['physicalDamageDealtToChampions'].'</div>';
            $i++;} echo'
          </div>
          <div class="entry">
            <div class="entrywidth">Magic Damage to Champions</div>
            ';$i =0; while ($i < $nop){
              echo '<div class="entrywidth">'.$Match['participants'][$i]['stats']['magicDamageDealtToChampions'].'</div>';
            $i++;} echo'
          </div>
          <div class="entry">
            <div class="entrywidth">True Damage to Champions</div>
            ';$i =0; while ($i < $nop){
              echo '<div class="entrywidth">'.$Match['participants'][$i]['stats']['trueDamageDealtToChampions'].'</div>';
            $i++;} echo'
          </div>
          <div class="entry">
            <div class="entrywidth">Total Damage Dealt</div>
            ';$i =0; while ($i < $nop){
              echo '<div class="entrywidth">'.$Match['participants'][$i]['stats']['totalDamageDealt'].'</div>';
            $i++;} echo'
          </div>
          <div class="entry">
            <div class="entrywidth">Physical Damage Dealt</div>
            ';$i =0; while ($i < $nop){
              echo '<div class="entrywidth">'.$Match['participants'][$i]['stats']['physicalDamageDealt'].'</div>';
            $i++;} echo'
          </div>
          <div class="entry">
            <div class="entrywidth">Magic Damage Dealt</div>
            ';$i =0; while ($i < $nop){
              echo '<div class="entrywidth">'.$Match['participants'][$i]['stats']['magicDamageDealt'].'</div>';
            $i++;} echo'
          </div>
          <div class="entry">
            <div class="entrywidth">True Damage Dealt</div>
            ';$i =0; while ($i < $nop){
              echo '<div class="entrywidth">'.$Match['participants'][$i]['stats']['trueDamageDealt'].'</div>';
            $i++;} echo'
          </div>
          <div class="entry">
            <div class="entrywidth">Largest Critical Strike</div>
            ';$i =0; while ($i < $nop){
              echo '<div class="entrywidth">'.$Match['participants'][$i]['stats']['largestCriticalStrike'].'</div>';
            $i++;} echo'
          </div>
          <div class="entry">
            <div class="entrywidth">Total Damage to Objectives</div>
            ';$i =0; while ($i < $nop){
              echo '<div class="entrywidth">'.$Match['participants'][$i]['stats']['damageDealtToObjectives'].'</div>';
            $i++;} echo'
          </div>
          <div class="entry">
            <div class="entrywidth">Total Damage to Turrets</div>
            ';$i =0; while ($i < $nop){
              echo '<div class="entrywidth">'.$Match['participants'][$i]['stats']['damageDealtToTurrets'].'</div>';
            $i++;} echo'
          </div>
        </div>

        <input class="tabdwn" type="checkbox" name="dwn3" id="tab3" checked/>
        <label for="tab3"><div>DAMAGE TAKEN AND HEALED</div></label>
        <div id="tab3content">
          <div class="entry">
            <div class="entrywidth">Damage Healed</div>
            ';$i =0; while ($i < $nop){
              echo '<div class="entrywidth">'.$Match['participants'][$i]['stats']['totalHeal'].'</div>';
            $i++;} echo'
          </div>
          <div class="entry">
            <div class="entrywidth">Damage Taken</div>
            ';$i =0; while ($i < $nop){
              echo '<div class="entrywidth">'.$Match['participants'][$i]['stats']['totalDamageTaken'].'</div>';
            $i++;} echo'
          </div>
          <div class="entry">
            <div class="entrywidth">Physical Damage Taken</div>
            ';$i =0; while ($i < $nop){
              echo '<div class="entrywidth">'.$Match['participants'][$i]['stats']['physicalDamageTaken'].'</div>';
            $i++;} echo'
          </div>
          <div class="entry">
            <div class="entrywidth">Magic Damage Taken</div>
            ';$i =0; while ($i < $nop){
              echo '<div class="entrywidth">'.$Match['participants'][$i]['stats']['magicalDamageTaken'].'</div>';
            $i++;} echo'
          </div>
          <div class="entry">
            <div class="entrywidth">True Damage Taken</div>
            ';$i =0; while ($i < $nop){
              echo '<div class="entrywidth">'.$Match['participants'][$i]['stats']['trueDamageTaken'].'</div>';
            $i++;} echo'
          </div>
          <div class="entry">
            <div class="entrywidth">Self Mitigated Damage</div>
            ';$i =0; while ($i < $nop){
              echo '<div class="entrywidth">'.$Match['participants'][$i]['stats']['damageSelfMitigated'].'</div>';
            $i++;} echo'
          </div>
        </div>

        <input class="tabdwn" type="checkbox" name="dwn4" id="tab4" checked/>
        <label for="tab4"><div>VISION</div></label>
        <div id="tab4content">
          <div class="entry">
            <div class="entrywidth">Vision Score</div>
            ';$i =0; while ($i < $nop){
              echo '<div class="entrywidth">'.$Match['participants'][$i]['stats']['visionScore'].'</div>';
            $i++;} echo'
          </div>
          <div class="entry">
            <div class="entrywidth">Wards Placed</div>
            ';$i =0; while ($i < $nop){
              echo '<div class="entrywidth">'.$Match['participants'][$i]['stats']['wardsPlaced'].'</div>';
            $i++;} echo'
          </div>
          <div class="entry">
            <div class="entrywidth">Wards Destroyed</div>
            ';$i =0; while ($i < $nop){
              echo '<div class="entrywidth">'.$Match['participants'][$i]['stats']['wardsKilled'].'</div>';
            $i++;} echo'
          </div>
          <div class="entry">
            <div class="entrywidth">Control Wards Purchased</div>
            ';$i =0; while ($i < $nop){
              echo '<div class="entrywidth">'.$Match['participants'][$i]['stats']['visionWardsBoughtInGame'].'</div>';
            $i++;} echo'
          </div>
        </div>


        <input class="tabdwn" type="checkbox" name="dwn5" id="tab5" checked/>
        <label for="tab5"><div>INCOME</div></label>
        <div id="tab5content">
          <div class="entry">
            <div class="entrywidth">Gold Earned</div>
            ';$i =0; while ($i < $nop){
              echo '<div class="entrywidth">'.$Match['participants'][$i]['stats']['goldEarned'].'</div>';
            $i++;} echo'
          </div>
          <div class="entry">
            <div class="entrywidth">Gold Spent</div>
            ';$i =0; while ($i < $nop){
              echo '<div class="entrywidth">'.$Match['participants'][$i]['stats']['goldSpent'].'</div>';
            $i++;} echo'
          </div>
          <div class="entry">
            <div class="entrywidth">Minions Killed</div>
            ';$i =0; while ($i < $nop){
              echo '<div class="entrywidth">'.$Match['participants'][$i]['stats']['totalMinionsKilled'].'</div>';
            $i++;} echo'
          </div>
          <div class="entry">
            <div class="entrywidth">Neutral Minions Killed</div>
            ';$i =0; while ($i < $nop){
              echo '<div class="entrywidth">'.$Match['participants'][$i]['stats']['neutralMinionsKilled'].'</div>';
            $i++;} echo'
          </div>
          <div class="entry">
            <div class="entrywidth">Neutral Minions Killed in Team Jungle</div>
            ';$i =0; while ($i < $nop){
              echo '<div class="entrywidth">'.$Match['participants'][$i]['stats']['neutralMinionsKilledTeamJungle'].'</div>';
            $i++;} echo'
          </div>
          <div class="entry">
            <div class="entrywidth">Neutral Minions Killed in Enemy Jungle</div>
            ';$i =0; while ($i < $nop){
              echo '<div class="entrywidth">'.$Match['participants'][$i]['stats']['neutralMinionsKilledEnemyJungle'].'</div>';
            $i++;} echo'
          </div>
        </div>


        <input class="tabdwn" type="checkbox" name="dwn6" id="tab6" checked/>
        <label for="tab6"><div>MISC</div></label>
        <div id="tab6content">
          <div class="entry">
            <div class="entrywidth">Towers Destroyed</div>
            ';$i =0; while ($i < $nop){
              echo '<div class="entrywidth">'.$Match['participants'][$i]['stats']['turretKills'].'</div>';
            $i++;} echo'
          </div>
          <div class="entry">
            <div class="entrywidth">Inhibitors Destroyed</div>
            ';$i =0; while ($i < $nop){
              echo '<div class="entrywidth">'.$Match['participants'][$i]['stats']['inhibitorKills'].'</div>';
            $i++;} echo'
          </div>
        </div>

      </div>

    </div>
    ';

    ?>
