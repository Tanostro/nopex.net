<?php
$r = 0;
$team1Unrankeds = $team2Unrankeds = 0;
$team1Points = $team2Points = 0;
foreach ($Match["participants"] as $Sum) {
  $countPoints = 0;
  if (!empty($Sum["rankedStats"])){
    foreach ($Sum["rankedStats"] as $Rank) {
      switch (strtolower($Rank["tier"])) {
          case 'unranked':
            $points = 0;
            break;
          case 'iron':
            $points = 400;
            break;
          case 'bronze':
            $points = 800;
            break;
          case 'silver':
            $points = 1200;
            break;
          case 'gold':
            $points = 1600;
            break;
          case 'platinum':
            $points = 2000;
            break;
          case 'diamond':
            $points = 2400;
            break;
          case 'master':
            $points = 2800;
            break;
          case 'grandmaster':
            $points = 2800;
            break;
          case 'challenger':
            $points = 2800;
            break;
        default:
          $points = 0;
          break;
      }
      switch (strtoupper($Rank["rank"])) {
          case 'IV':
            $points = $points + 0;
            break;
          case 'III':
            $points = $points + 100;
            break;
          case 'II':
            $points = $points + 200;
            break;
          case 'I':
            $points = $points + 300;
            break;
          default:
           $points = $points + 0;
           break;
      }
      if (!empty($Rank["leaguePoints"])){
        $points = $points + $Rank["leaguePoints"];
      } else { $points = $points + 100; }
      $countPoints = $countPoints + $points;
    }
  } else {
    if ($r < $playerCount / 2){
      $team1Unrankeds = $team1Unrankeds + 1;
    } else {
      $team2Unrankeds = $team2Unrankeds + 1;
    }
  }
  $r ++;
  if ($r <= $playerCount / 2){
    $team1Points = $team1Points +$countPoints;
  } else {
    $team2Points = $team2Points +$countPoints;
  }
}

if ($team1Unrankeds + $team2Unrankeds < 4 ){
  $team1Points = $team1Points + ($team1Unrankeds * ($team1Points / ($playerCount - $team2Unrankeds)));
  $team2Points = $team2Points + ($team2Unrankeds * ($team1Points / ($playerCount - $team2Unrankeds)));

  $team1Percents = round((100 * $team1Points) / ($team1Points + $team2Points));
  $team2Percents = 100 - $team1Percents;
  $toManyUnrankeds = "";
} else {
  $toManyUnrankeds = "toManyUnrankeds";
  $team1Percents = 50;
  $team2Percents = 50;
}

echo '<div class="middle">
        <div class="blueSide '.$toManyUnrankeds.'" style="width: '.$team1Percents.'%;">
          <div class="left">';

        $midpart = '</div><div class="percent" title="Approximate chance of winning by the blue team">'.$team1Percents.' %</div></div>
                <div class="redSide '.$toManyUnrankeds.'" style="width: '.$team2Percents.'%;"><div title="Approximate chance of winning by the red team" class="percent">'.$team2Percents.' %</div><div class="right">';
        $b = 0;
        if (!empty($Match["bannedChampions"] )){
          foreach ($Match["bannedChampions"] as $ban) {
            if ($ban["championId"] != -1){
              $bannedChamp = $championDB[$ban["championId"]]['key'];
              echo '<img class="Ban" src="https://ddragon.leagueoflegends.com/cdn/'.$LiveVersion.'/img/champion/'.$bannedChamp.'.png" />';
            } else {
              echo '<div class="Ban"></div>';
            }

            $b ++;
            if ($playerCount / 2  == $b){
              echo $midpart;
            }
          }
        } else {echo $midpart;}
        echo
        '</div>
        </div>
      </div>'
 ?>
