<?php
  $i = 0;
  foreach ($Match["participants"] as $row) {
    $rankedStats = apicall("league_by_sumid",$Region,$row["summonerId"],0);
    $SumData[$i]["rankedStats"] = $rankedStats;
    $Match["participants"][$i]["rankedStats"] = $rankedStats;

    $MasteryLevel = apicall("champ_by_sumid_champid",$Region,$row["summonerId"],$row["championId"]);
    $SumData[$i]["MasteryLevel"] = $MasteryLevel;
    $Match["participants"][$i]["MasteryLevel"] = $MasteryLevel;

    $Sumlevel = apicall("summoner_by_id",$Region,$row["summonerId"],0);
    $SumData[$i]["summonerLevel"] = $Sumlevel["summonerLevel"];
    $Match["participants"][$i]["summonerLevel"] = $Sumlevel["summonerLevel"];
    $i ++;
  }
  unset($rankedStats); unset($MasteryLevel); unset($Sumlevel);

  $JSON_SumData = str_replace("'", "?",json_encode($SumData));
  $timestmp = time();
  $query = "INSERT INTO $Region (matchId, timestmp, sumData) VALUES ('$MatchId', '$timestmp', '$JSON_SumData')";
  $mysqli->query($query);
  unset($JSON_SumData);unset($SumData);
 ?>
