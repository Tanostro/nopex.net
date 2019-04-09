<?php
include $_SERVER["DOCUMENT_ROOT"]."/source/php/main.php";

$mysqli = @new mysqli('############', '############', '############', '############');
if ($mysqli->connect_error){
  $sql_con_error = true;
} else {$sql_con_error = false;}

include $_SERVER["DOCUMENT_ROOT"]."/source/php/api.php";
$P_CONTENT = json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"]."/match/lang/".$_COOKIE["lang"].".json"),true);

$LiveVersion = apicall("liveversion",0,0,0)[0];


//##############################################################################
//##############################################################################

$regions = json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"]."/source/loldata/regions.json"), true);
if (empty($_GET['region'])){
  $Region = $_COOKIE['region'];
} else {
  foreach ($regions as $row) {
    if (strtoupper($_GET['region']) == $row["name"]){
      $Region = $row['id'];
      break;
    }
  }
}

if ($_GET['id'] != "gettemplate"){
  $SummonerName = str_replace(" ", "%20",$_GET['id']);
  $Summoner = @apicall('summoner_by_name',$Region,$SummonerName,0);
  if (empty($Summoner)){ echo '
    <div id="errorbox">
    <p>'.$P_CONTENT["t_sum_not_found"].'</p>
    '.sprintf($P_CONTENT["sum_not_found"], $_GET['id']).'
    </div>
    ';
  }

  $Match = @apicall('livematch_by_sumid',$Region,$Summoner['id'],0);
  if (empty($Match)){ die ('
    <div id="errorbox">
    <p>'.$P_CONTENT["t_match_not_found"].'</p>
    <a href="../summoner/?region='.$Region.'&id='.$_GET['id'].'"
    style="color: #2B6CA3; font-weight: 600;">'.$_GET['id'].'</a>
    '.$P_CONTENT["match_not_found"].'
    </div>
    ');
  }

} else {
  $Match = json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"]."/match/php/template.json"), true);
}

$MatchId = $Match["gameId"];

if ($sql_con_error == false){
  $query = "SELECT * FROM $Region WHERE matchId='$MatchId' ";
  $result = $mysqli->query($query);
  $count = mysqli_num_rows($result);
  if ($count > 0){
    foreach ($result as $row);
    $i = 0;
    $sumData = json_decode($row["sumData"], true);
    foreach ($sumData as $row) {
      $Match["participants"][$i]["rankedStats"] = $row["rankedStats"];
      $Match["participants"][$i]["MasteryLevel"] = $row["MasteryLevel"];
      $Match["participants"][$i]["summonerLevel"] = $row["summonerLevel"];

      $i ++;
    }
    unset($row);
  } else {
    include $_SERVER["DOCUMENT_ROOT"]."/match/php/new-match.php";
  }
} else {
  include $_SERVER["DOCUMENT_ROOT"]."/match/php/new-match.php";
}

include $_SERVER["DOCUMENT_ROOT"]."/match/php/matchboard.php";

?>
