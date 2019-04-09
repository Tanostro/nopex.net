<?php
include $_SERVER["DOCUMENT_ROOT"]."/source/php/api.php";
if (empty($_COOKIE["region"])){
  setcookie("region", "euw1", time()+315360000, '/', NULL, 0);
  $_COOKIE["region"] = "euw1";
}

$mysqli = @new mysqli('############', '############', '############', '############');
if ($mysqli->connect_error){
  $errorMsg = $CONTENT["database_connection_error"];
} else
if (!empty($_POST)){
  if (!empty($_POST["sumName"])){

    $uuid = $_SESSION['user']['uuid'];
    $query = "SELECT league_code FROM verification WHERE uuid='$uuid' ";
    $result = $mysqli->query($query);
    foreach ($result as $row);

    $SummonerData = apicall("summoner_by_name",$_COOKIE["region"],$_POST["sumName"],0);
    if (isset($SummonerData["id"])){
      $verCode = apicall("third_party_code",$_COOKIE["region"],$SummonerData["id"],0);
      if (empty($verCode)){
    			$errorMsg = $CONTENT["tpa-failed"];
    	} else {
        if ($verCode == $row["league_code"]){
          $leagueId = $SummonerData["puuid"]; $leagueRegion = $_COOKIE["region"];
          $query = "UPDATE users SET ver_league=true, league_puuid='$leagueId', league_region='$leagueRegion' WHERE uuid='$uuid' ";
          $mysqli->query($query);
          $_SESSION['user']['ver_league'] = true;
          header ('Location: http://'.$_SERVER['HTTP_HOST'].'/summoner/?id='.$SummonerData["id"]);
        } else { $errorMsg = $CONTENT["try-again"]; }
      }
    } else { $errorMsg = $CONTENT["sum-not-found"]; }
  }
} ?>
