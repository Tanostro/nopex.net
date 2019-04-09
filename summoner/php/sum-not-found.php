<?php
$regionName = strtoupper($region);
$query = "INSERT INTO  `$regionName` (`sumId`,`matchHistory`,`rankedChampStats`) VALUES ('$SummonerID','','')";
$mysql->query($query);
echo '<div id="sum-not-found">
        <h1> Sumoner  not found.</h1>
        <span id="updatefont">Collecting data</span>
        <script>
        window.onload = function (){
          function updateSum(){
          document.getElementById("updatefont").innerHTML = "Updating ...";
          var connection = new WebSocket(\'wss://www.nopex.net:7070\');
          connection.onopen = function () {
            connection.send(\'Request Update\');
          };
          connection.onmessage = function (e) {
            console.log(\'Server: \' + e.data);
              if (e.data == "finished"){
                location.reload();
              } else
                if (e.data == "Waiting_for_Information"){
                  connection.send(\'{"SumId":"'.$SummonerID.'","region":"'.strtoupper($region).'"}\');
                  console.log(\'{"SumId":"'.$SummonerID.'","region":"'.strtoupper($region).'"}\');
                  }
                document.getElementById("updatefont").innerHTML = e.data;
          };
          setTimeout(function () {
            if (connection.readyState != 1) {
              document.getElementById("updatefont").innerHTML = "Can\'t connect to Update Server. Please try again later.";
            }
          }, 3000);
        };
          updateSum();
        }
        </script>
      </div>';
?>
