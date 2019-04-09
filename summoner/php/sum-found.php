<?php
echo'
<div id="Summoner">
  <div class="header" style="background: url(https://ddragon.leagueoflegends.com/cdn/img/champion/splash/Ashe_0.jpg); background-size: cover; background-position: 0% 25%;">
    <div class="info">
    <img class="icon" src="'.'https://ddragon.leagueoflegends.com/cdn/'.$LiveVersion.'/img/profileicon/'.$SummonerIconId.'.png" width="75px;"></img>
    <span class="level">'.$SummonerLevel.'</span>
    <div class="name">'.$SummonerName.'</div>
    </div>
  </div>
  <div class="subheader">
    <button name="reload_sub" id="reload_sub" onClick="updateSum()">Update</button>
    <span id="updatefont"> Last updated: N/A </span>
  </div>

<input type="radio" name="menu" id="overview" checked/>
<label for="overview" id="owl">
  <div class="navpoint">Overview</div></label>

<input type="radio" name="menu" id="match_history"/>
<label  for="match_history" id="mhl">
  <div class="navpoint">Match History</div></label>

<input type="radio" name="menu" id="champions"/>
<label for="champions" id="cl">
  <div class="navpoint">Champions</div></label>

<input type="radio" name="menu" id="leagues"/>
<label  for="leagues" id="ll">
  <div class="navpoint">Ranked</div></label>

<div id="livematch_box"></div>
';
$regionName = strtoupper($Region);
        $query = "SELECT * FROM $regionName WHERE sumId='$SummonerId'";
        foreach ($mysql->query($query) as $row);
        $row['leagues'] = mb_convert_encoding($row['leagues'], 'UTF-8', 'UTF-8');
        $RanksCache = json_decode($row['leagues'], true);
        echo'
        <div id="overviewbox" style="height: 685px;">
          <div style="float: left;">
            <div id="summonerranks">
              <center class="headbox"><span>Ranks - Season 8</span></center>
              ';
              include './include/ranks.php';

        echo'
            </div>
            <div id="summonerchamps" style="min-height: 480px; margin-top: 120px;">
            ';
            $regionName = strtoupper($Region);
            $query = "SELECT rankedChampStats FROM $regionName WHERE sumId='$SummonerId'";
            foreach ($mysql->query($query) as $row);
            //$row['rankedChampStats'] = mb_convert_encoding($row['rankedChampStats'], 'UTF-8', 'UTF-8');
            $RanksCache = json_decode($row['rankedChampStats'], true);
            if (empty($RanksCache)){
              $query = "SELECT champMasteries FROM $regionName WHERE sumId='$SummonerId'";
              foreach ($mysql->query($query) as $row);
              $RanksCache = json_decode($row['champMasteries'], true);
              $headtext = "Top 6 - Mastery Champions";
            } else {
              $RanksCache = $RanksCache[1];
              $headtext = "Top 6 - Ranked Season 8";
            }
            include './include/topchamps.php';
            echo '
            </div>
          </div>
          <div id="matchlist" style="min-height: 651px;">
          ';
          $regionName = strtoupper($Region);
          $query = "SELECT matchHistory FROM $regionName WHERE sumId='$SummonerId'";
          foreach ($mysql->query($query) as $row);
          $row['matchHistory'] = mb_convert_encoding($row['matchHistory'], 'UTF-8', 'UTF-8');
          $MHCache = json_decode($row['matchHistory'], true);

          include './include/recentmatches.php';
          echo'
          </div>
        </div>

        <div style="height: 1350px; width: 1080px; margin: auto; margin-bottom: 50px;" id="match_historybox">
          ';
          $regionName = strtoupper($Region);
          $query = "SELECT matchHistory FROM $regionName WHERE sumId='$SummonerId'";
          foreach ($mysql->query($query) as $row);
          $row['matchHistory'] = mb_convert_encoding($row['matchHistory'], 'UTF-8', 'UTF-8');
          $MHCache = json_decode($row['matchHistory'], true);

          include './include/matchhistory.php';
          echo'
          </div>
        </div>

        <div id="championsbox" style="width: 1080px; margin: auto; margin-bottom: 25px; min-height: 500px;">
           <div style="height: 500px; background-color: white;">
            <div style="text-align: center; float: left; width: 100%; margin-top: 225px;">
            DISABLED </div> </div>
        </div>

        <div id="leaguesbox" style="width: 1080px; margin:auto; min-height: 800px; margin-bottom: 60px;">
        ';
        $regionName = strtoupper($Region);
        $query = "SELECT leagues FROM $regionName WHERE sumId='$SummonerId'";
        foreach ($mysql->query($query) as $row);
        $row['leagues'] = mb_convert_encoding($row['leagues'], 'UTF-8', 'UTF-8');
        $RanksCache = json_decode($row['leagues'], true);

        include './include/leagues.php';
        echo'
        </div>
  </div>
'; ?>
