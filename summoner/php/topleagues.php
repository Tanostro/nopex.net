<?php
function topleagues($type,$name){
  $API_KEY="RGAPI-b04f4272-1938-4b95-96f3-ea86883193de";
  $url = "https://".$_COOKIE["region"].".api.riotgames.com/lol/league/v4/$type/by-queue/RANKED_SOLO_5x5?api_key=$API_KEY";
  $c = 0;
  while($c<10){
    $data = json_decode(file_get_contents($url), true);
    if ($http_response_header['0'] == "HTTP/1.1 200 OK") {
      break;
    } else
    if ($http_response_header['0'] == "HTTP/1.1 400 Bad Request"){
      return Null;
    } else
    if ($http_response_header['0'] == "HTTP/1.1 403 Forbidden"){
      return Null;
    } else
    if ($http_response_header['0'] == "HTTP/1.1 404 Not Found"){
      return Null;
    }
    ++$c;
  }
  if (!empty($data["entries"])){
    foreach($data["entries"] as $key => $array) {
    $sortArray[$key] = $array['leaguePoints'];
    }
  array_multisort($sortArray, SORT_DESC, SORT_NUMERIC, $data["entries"]);

  echo '<div class="leaguelist">
  <div class="head">
    <img src="http://'.$_SERVER['HTTP_HOST'].'/source/img/tier/'.$name.'.png" />
    <span>'.ucfirst($name).' - Solo/Duo</span>
  </div>
  ';
  $count = count($data["entries"]);
  $numOfSites = ceil($count / 15); $i = 0;

  if ($numOfSites > 15){$numOfSites = 15;}

  while ($i < $numOfSites){
    $i ++;
    echo '<input name="'.$type.'" type="radio" id="'.$type.'_'.$i.'" ';
    if ($i == 1){echo "checked";}
    echo'/>';
  }
  echo '
  <div class="sumBox" id="'.$type.'Box_1">
    ';
      $i = 0; $p = 1; $e = 0;
      foreach ($data["entries"] as $Sum) {
        $i ++; $e ++;
        echo '<div class="sum">
                <div>'.$i.'</div>
                <a href="http://'.$_SERVER["HTTP_HOST"].'/summoner/?id='.$Sum["summonerName"].'">
                  '.$Sum["summonerName"].'
                </a>
                <span>'.$Sum["leaguePoints"].' LP</span>
              </div>';

        if ($e >= 15){
          $e = 0; $p ++;
          echo '</div> <div class="sumBox" id="'.$type.'Box_'.$p.'">';
        }

      }
    echo '
  </div><div class="foot-nav">
  ';

    $count = count($data["entries"]);
    $i = 0;
    while ($i < $numOfSites){
      $i ++;
      echo '<label for="'.$type.'_'.$i.'" type="radio" ><div>'.$i.'</div></ label>';
    }
    echo "</div></div>";
  } else {
    echo '<div class="leaguelist">
    <div class="head">
      <img src="http://'.$_SERVER['HTTP_HOST'].'/source/img/tier/'.$name.'.png" />
      <span>'.ucfirst($name).' - Solo/Duo</span>
    </div>
    <div class="sumBox" style="display: block;">
      <div class="rankedclosed">
      <img src="http://'.$_SERVER['HTTP_HOST'].'/source/img/tier/unranked.png" width="100px"></img><br>

      There are no players in this Elo yet.

      </div>
    </div>
    <div class="foot-nav"> &nbsp; </div>
    </div>
    ';
  }
}
?>
