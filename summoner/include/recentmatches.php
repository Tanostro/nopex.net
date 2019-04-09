<?php
$diemsg = '<div style="padding: 5px; text-align: center; color: #3484c1;
          margin-top: 40px;"> no data</div>';
// ### API key ###
$API_KEY="RGAPI-b04f4272-1938-4b95-96f3-ea86883193de";

if (empty($sum_name)){
    $mysqli = @new mysqli('############', '############', '############', '############');
    if ($mysql->connect_error) {
            die("Database connection error.");
          }
    // ### SUMMONERNAME ###
    $Summoner_name = str_replace(" ", "%20",$_GET['id']);
    $sum_name = $_GET['id'];

    // ### LiveVersion ###
        $get_Version = "https://ddragon.leagueoflegends.com/api/versions.json";
        $Version = json_decode(file_get_contents($get_Version), true);
        $LiveVersion = $Version['0'];

    // ### REGION ###
    if (empty($_GET['region'])){
      die ($diemsg);
    }
      else {
        if ($_GET['region'] == "euw"){ $region = "euw1";$regionId = 1;};
        if ($_GET['region'] == "eun"){ $region = "eun1";$regionId = 2;};
        if ($_GET['region'] == "na"){ $region = "na1";$regionId = 3;};
        if ($_GET['region'] == "br"){ $region = "br1";$regionId = 4;};
        if ($_GET['region'] == "jp"){ $region = "jp1";$regionId = 5;};
        if ($_GET['region'] == "kr"){ $region = "kr";$regionId = 6;};
        if ($_GET['region'] == "lan"){ $region = "la1";$regionId = 7;};
        if ($_GET['region'] == "las"){ $region = "la2";$regionId = 8;};
        if ($_GET['region'] == "oc"){ $region = "oc1";$regionId = 9;};
        if ($_GET['region'] == "tr"){ $region = "tr1";$regionId = 10;};
        if ($_GET['region'] == "ru"){ $region = "ru";$regionId = 11;};
      }
      // ### SUMMONER PROFILE ###
      $get_Summoner = "https://$Region.api.riotgames.com/lol/summoner/v4/summoners/by-name/$Summoner_name?api_key=$API_KEY";
      $Summoner = json_decode(file_get_contents($get_Summoner), true);
      if (empty($Summoner)){
        die ($diemsg);
      }
      $SummonerID = $Summoner['id'];
      $SummonerName = $Summoner['name'];
      $SummonerIconId = $Summoner['profileIconId'];
      $SummonerLevel = $Summoner['summonerLevel'];
      $SummonerAccId = $Summoner['accountId'];
    $regionName = strtoupper($region);
    $query = "SELECT matchHistory FROM $regionName WHERE sumId='$SummonerID'";
    foreach ($mysql->query($query) as $row);
    $row['matchHistory'] = mb_convert_encoding($row['matchHistory'], 'UTF-8', 'UTF-8');
    $MHCache = json_decode($row['matchHistory'], true);

}
      echo'<div class="headbox" style="text-align: center; text-shadow: none;"><span>Last 10 Matches</span></div>
      ';

      $mh = 0;
      foreach ($MHCache as $row) {
        if ($mh >=10){ break; }
        $MHid = $row['matchid'];
        $MHborder = $row['border'];
        $MHchampion = $row['champ'];
        $MHchampion  = str_replace(" ", "",$MHchampion);
        $MHchampion  = str_replace("'", "",$MHchampion);
        $MHchampLvl = $row['champlvl'];
        $Spell1 = $row['spell1'];
        $Spell2 = $row['spell2'];
        if ($MHborder == "#2B6CA3")
        {$MHWoL= '<span style="color: #2B6CA3;font-size: 28px; margin-left: 5px;">VICTORY</span>';} else if ($MHborder == "#B22222") {$MHWoL= '<span style="color: #B22222; font-size: 28px; margin-left: 5px;">DEFEAT</span>';}
        $MHkda = $row['KDA'];
        $MHitem1 = $row['item1'];
        $MHitem2 = $row['item2'];
        $MHitem3 = $row['item3'];
        $MHitem4 = $row['item4'];
        $MHitem5 =$row['item5'];
        $MHitem6 = $row['item6'];
        $MHward = $row['ward'];
        $MHGamemode = $row['gamemode'];
        $MHtimestamp = $row['timestmp']/1000;
        $MHmapID = $row['mapId'];
        if (!empty($MHmapID)){
          if($MHmapID==1){$MapPig = "SR";}
          if($MHmapID==10){$MapPig = "TT";}
          if($MHmapID==11){$MapPig = "SR";}
          if($MHmapID==12){$MapPig = "HA";}
          }

          $timedif = time() - $MHtimestamp;
          $tag  = floor($timedif / (3600*24));
          $std  = floor($timedif / 3600 % 24);
          $min  = floor($timedif / 60 % 60);
          $sek  = floor($timedif % 60);

          $MHfulltimestamp = "$tag day(s) $std hour(s) $min min";

          if ($tag !=0){ $MHtimestamp = "$tag d ago";} else if ($std !=0){ $MHtimestamp = "$std h ago";} else if ($min !=0){ $MHtimestamp = "$min min ago";} else if ($sek !=0){ $MHtimestamp = "$sek s ago";}

          $MHgameDuration = $row['gameDuration'];
          $std  = floor($MHgameDuration / 3600 % 24);
          $min  = floor($MHgameDuration / 60 % 60);
          $sek  = floor($MHgameDuration % 60);

          $MHfullgameDuration = "$std hour(s) $min min $sek s";

          if ($std !=0){ $MHgameDuration = "$std h";} else if ($min !=0){ $MHgameDuration = "$min min";} else if ($sek !=0){ $MHgameDuration = "$sek s";}

        echo '<a href="/game/?region='.$_COOKIE['region'].'&id='.$MHid.'">
        <div class="match" style="width: 795; height: 50px; border-color:'; echo $MHborder; echo';
        background-image: linear-gradient(to right, rgba(0,0,0,0.8), transparent) , url(/source/img/Map/'; if (!empty($MapPig)){echo $MapPig;} else { echo "SR";} echo'.jpg) ;
        background-size: 100%; background-position: 70%">
                <div style="height: 50px; width: 340px; float: left;">
                <div><img class="champpig" width="50px" src="https://ddragon.leagueoflegends.com/cdn/'.$LiveVersion.'/img/champion/'; echo $MHchampion; echo'.png"></img></div>
                <div class="champlvl">'; echo $MHchampLvl; echo'</div>
                <div style="height: 50px;">
                <img src="'; echo $Spell1; echo'" height="25px" style="border-radius: 30%;"></img><br>
                <img src="'; echo $Spell2; echo'" height="25px" style="border-radius: 30%;"></img></div>
                <div style="font-size: 20px; height: 50px; margin-top: -45px; margin-left: 90px;">'; echo $MHWoL; echo'<span style="margin-left: 30px;" title="Kills / Deaths / Assists">&nbsp;&nbsp;&nbsp;'; echo $MHkda; echo'</span></div>
                </div>
                <div class="itembox" style="float: left;margin-top: 9px;">
                <div class="itemsquare">';  if (!empty($MHitem1)){ echo '<img class="itempig" src="https://ddragon.leagueoflegends.com/cdn/'.$LiveVersion.'/img/item/'.$MHitem1.'.png"></img>';} echo'</div>
                <div class="itemsquare">';  if (!empty($MHitem2)){ echo '<img class="itempig" src="https://ddragon.leagueoflegends.com/cdn/'.$LiveVersion.'/img/item/'.$MHitem2.'.png"></img>';} echo'</div>
                <div class="itemsquare">';  if (!empty($MHitem3)){ echo '<img class="itempig" src="https://ddragon.leagueoflegends.com/cdn/'.$LiveVersion.'/img/item/'.$MHitem3.'.png"></img>';} echo'</div>
                <div class="itemsquare">';  if (!empty($MHitem4)){ echo '<img class="itempig" src="https://ddragon.leagueoflegends.com/cdn/'.$LiveVersion.'/img/item/'.$MHitem4.'.png"></img>';} echo'</div>
                <div class="itemsquare">';  if (!empty($MHitem5)){ echo '<img class="itempig" src="https://ddragon.leagueoflegends.com/cdn/'.$LiveVersion.'/img/item/'.$MHitem5.'.png"></img>';} echo'</div>
                <div class="itemsquare">';  if (!empty($MHitem6)){ echo '<img class="itempig" src="https://ddragon.leagueoflegends.com/cdn/'.$LiveVersion.'/img/item/'.$MHitem6.'.png"></img>';} echo'</div>
                <div class="itemsquare">';  if (!empty($MHward)){ echo '<img class="itempig" src="https://ddragon.leagueoflegends.com/cdn/'.$LiveVersion.'/img/item/'.$MHward.'.png"></img>';} echo'</div>
                  </div>
                  <div style="width: 150px; float: right; text-align: right; margin-right: 5px; margin-top: 5px;">';
                echo '<div>'; echo $MHGamemode; echo'</div>
                <div>
                <span title="GameDuration: '; echo $MHfullgameDuration ; echo'">'; echo $MHgameDuration; echo'</span>
                &nbsp;-&nbsp;
                <span title="'; echo $MHfulltimestamp; echo' ago">'; echo $MHtimestamp; echo'</span></div>
                </div>
              </div>
              </a>
        ';
        ++$mh;
      }
