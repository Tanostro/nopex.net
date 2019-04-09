<?php
$get_League = "https://$region.api.riotgames.com/lol/league/v3/leagues/$LeagueID?api_key=$API_KEY";
$League = json_decode(file_get_contents($get_League), true);
//$League = json_decode(file_get_contents("../summoner/test.txt"), true);
echo '<div class="leagueHead"><img style="float:left;" width="40px;"src="/source/img/Tier/'
.strtolower($League['tier']).'.png"</img><div class="leagueHeadfont">'.$LeagueName.'</div>';

if(($League['tier'] != "CHALLENGER") AND ($League['tier'] != "MASTER")){

$Tier['I'] = "";$iI = 0;
$Tier['II'] = "";$iII = 0;
$Tier['III'] = "";$iIII = 0;
$Tier['IV'] = "";$iIV = 0;
$Tier['V'] = "";$iV = 0;
$sortArray = array();
foreach($League['entries'] as $key => $array) {
    $sortArray[$key] = $array['leaguePoints'];
}

array_multisort($sortArray, SORT_DESC, SORT_NUMERIC, $League['entries']);
  $i=0;
  while( $i != -1){
    $LeaguePoints = $League['entries'][$i]['leaguePoints']." LP";
    if($League['entries'][$i]['leaguePoints'] == 100){
      $LeagueProgress = $League['entries'][$i]['miniSeries']['progress'];
      $LeaguePoints = "";
      $LeagueProgress = str_replace("N",'<div class="lp1"></div>',$LeagueProgress);
      $LeagueProgress = str_replace("L",'<div class="lp2"></div>',$LeagueProgress);
      $LeagueProgress = str_replace("W",'<div class="lp3"></div>',$LeagueProgress);
      $LeagueProgress = '<div class="LeagueProgress">'.$LeagueProgress.'</div>';
    } else {$LeagueProgress = "";}
  $place = "i".$League['entries'][$i]['rank'];
      $$place ++;
  $winrate = round($League['entries'][$i]['wins'] * 100 / ($League['entries'][$i]['wins'] + $League['entries'][$i]['losses']));
  $class='';
  if ($$place % 2 != 0) {$class='background-color: rgba(0, 0, 0, 0.05);';}
  $sumC = "";
  if ($_GET['id'] == $League['entries'][$i]['playerOrTeamName'] ){
    $PSTier = $League['entries'][$i]['rank']; $sumC = 'background: rgba(43, 108, 163, 0.9);';
  }
  /*
  $freshBlood ="";$hotStreak="";$Veteran="";
  if ($League['entries'][$i]['veteran'] == true){
  $Veteran = '<img title="Veteran - Played 100 or more games in this league"src="../../source/img/icons/veteran.png" width="24px" height="24px"/>';}
  if ($League['entries'][$i]['hotStreak'] == true){
  $hotStreak = '<img title="Hot Streak - Won 3 or more games in a row" src="../../source/img/icons/flame.png" width="24px" height="24px"/>';}
  if ($League['entries'][$i]['freshBlood'] == true){
  $freshBlood = '<img title="Recruit - Recently joint this league" src="../../source/img/icons/new.png" width="24px" height="24px"/>';}
  */
  $Tier[$League['entries'][$i]['rank']] .= '
      <div class="playerslot" style="'.$class.$sumC.'">
        <span style="font-size: 24px; float: left; margin-top: 6px;">'.$$place.'.
        '.$League['entries'][$i]['playerOrTeamName'].'</span>
        <span style="float: right; margin-top: 14px; margin-right: 10px; width: 100px; text-align: right;">'.$LeaguePoints.$LeagueProgress.'</span>
        <span style="float: right; margin-right: 10%; margin-top: 5px; width: 75px; text-align: center;"><span style="font-size: 18px;">'.$winrate.'%<br></span>
        <span style="font-size: 14px; position: relative; top: -3px;">
        <span style="color: #06cc06;">'.$League['entries'][$i]['wins'].'</span> / <span style="color: #F22222;">'.$League['entries'][$i]['losses'].'</span></span></span>
        '
        /*<div style="float: right;margin-top: 12px; margin-right: 20px;width: 24px;">'.$Veteran.'</div>
        <div style="float: right;margin-top: 12px; margin-right: 20px;width: 24px;">'.$hotStreak.'</div>
        <div style="float: right;margin-top: 12px; margin-right: 20px;width: 24px;">'.$freshBlood.'</div>*/
        .'
      </div>
    ';

  $i ++;
  if (empty($League['entries'][$i]['playerOrTeamName'])){$i = -1;}
  }
  }
  if(($League['tier'] != "CHALLENGER") AND ($League['tier'] != "MASTER")){
  echo '
        </div>
        <input style="display: none;" name="'.$LS.'menu" id="'.$LS.'checkI" '; if ($PSTier == "I"){echo 'checked="checked"';} echo' type="radio"></input>
        <label for="'.$LS.'checkI" class="Tierbtn"><span>I</span></label>

        <input style="display: none;" name="'.$LS.'menu" id="'.$LS.'checkII" type="radio"'; if ($PSTier == "II"){echo 'checked="checked"';} echo'></input>
        <label for="'.$LS.'checkII" class="Tierbtn"><span>II</span></label>

        <input style="display: none;" name="'.$LS.'menu" id="'.$LS.'checkIII"  type="radio"'; if ($PSTier == "III"){echo 'checked="checked"';} echo'></input>
        <label for="'.$LS.'checkIII" class="Tierbtn"><span>III</span></label>

        <input style="display: none;" name="'.$LS.'menu" id="'.$LS.'checkIV" type="radio"'; if ($PSTier == "IV"){echo 'checked="checked"';} echo'></input>
        <label for="'.$LS.'checkIV" class="Tierbtn"><span>IV</span></label>


';}

  echo '<div id="'.$LS.'tierI" class="Tierlist">'.$Tier['I'].'</div>
  <div id="'.$LS.'tierII"  class="Tierlist">'.$Tier['II'].'</div>
  <div id="'.$LS.'tierIII" class="Tierlist">'.$Tier['III'].'</div>
  <div id="'.$LS.'tierIV"  class="Tierlist">'.$Tier['IV'].'</div>';
?>
