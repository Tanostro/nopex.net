<?php

function apicall($type,$var1,$var2,$var3){
  $API_KEY="RGAPI-b04f4272-1938-4b95-96f3-ea86883193de";
  switch ($type) {
    //#############################################
    case 'summoner_by_name':
      if (!empty($var1)||!empty($var2)){
      $url = "https://$var1.api.riotgames.com/lol/summoner/v4/summoners/by-name/$var2?api_key=$API_KEY";
      }else{
        echo "Unzureichechende Variablen";
        return Null;
      }
      break;
    //#############################################
    case 'summoner_by_id':
      if (!empty($var1)||!empty($var2)){
      $url = "https://$var1.api.riotgames.com/lol/summoner/v4/summoners/$var2?api_key=$API_KEY";
      }else{
        echo "Unzureichechende Variablen";
        return Null;
      }
      break;
    //#############################################
    case 'summoner_by_uuid':
      if (!empty($var1)||!empty($var2)){
      $url = "https://$var1.api.riotgames.com/lol/summoner/v4/summoners/by-puuid/$var2?api_key=$API_KEY";
      }else{
        echo "Unzureichechende Variablen";
        return Null;
      }
      break;
    //#############################################
    case 'liveversion':
      $url = "https://ddragon.leagueoflegends.com/api/versions.json";
      break;
    //#############################################
    case 'livematch_by_sumid':
      if (!empty($var1)||!empty($var2)){
      $url = "https://$var1.api.riotgames.com/lol/spectator/v4/active-games/by-summoner/$var2?api_key=$API_KEY";
      } else {
        echo "Unzureichechende Variablen";
        return Null;
      }
      break;
    //#############################################
      case 'featured_matches':
        $url = "https://$var1.api.riotgames.com/lol/spectator/v4/featured-games/?api_key=$API_KEY";
        break;
    //#############################################

    case 'match_by_sumid':
      if (!empty($var1)||!empty($var2)){
      $url = "https://$var1.api.riotgames.com/lol/match/v4/matches/$var2?api_key=$API_KEY";
      } else {
        echo "Unzureichechende Variablen";
        return Null;
      }
      break;
    //#############################################
    case 'champ_by_sumid_champid':
      if (!empty($var1)||!empty($var2)){
      $url = "https://$var1.api.riotgames.com/lol/champion-mastery/v4/champion-masteries/by-summoner/$var2/by-champion/$var3?api_key=$API_KEY";
      } else {
        echo "Unzureichechende Variablen";
        return Null;
      }
      break;
    //#############################################
    case 'champ_by_sumid':
      if (!empty($var1)||!empty($var2)){
      $url = "https://$var1.api.riotgames.com/lol/champion-mastery/v4/champion-masteries/by-summoner/$var2/by-champion/$var3?api_key=$API_KEY";
      } else {
        echo "Unzureichechende Variablen";
        return Null;
      }
      break;
    //#############################################
    case 'champ_by_id_champid':
      if (!empty($var1)||!empty($var2)){
      $url = "https://$var1.api.riotgames.com/lol/champion-mastery/v4/champion-masteries/by-summoner/$var2?api_key=$API_KEY";
      } else {
        echo "Unzureichechende Variablen";
        return Null;
      }
      break;
    //#############################################
    case 'league_by_sumid':
      if (!empty($var1)||!empty($var2)){
      $url = "https://$var1.api.riotgames.com/lol/league/v4/positions/by-summoner/$var2/?api_key=$API_KEY";
      } else {
        echo "Unzureichechende Variablen";
        return Null;
      }
      break;
    //#############################################
    case 'third_party_code':
      if (!empty($var1)||!empty($var2)){
      $url = "https://$var1.api.riotgames.com/lol/platform/v4/third-party-code/by-summoner/$var2/?api_key=$API_KEY";
      } else {
        echo "Unzureichechende Variablen";
        return Null;
      }
      break;
    //#############################################
    default:
        return Null;
      break;
  }

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

  return $data;
}
