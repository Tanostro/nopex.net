<?php
$mysqli = @new mysqli('############', '############', '############', '############');
if ($mysqli->connect_error){
  $errorMsg = $CONTENT["database_connection_error"];
} else
if (!empty($_POST)){
  if ( !empty($_POST["email"]) &&
      !empty($_POST["password"])
  ){
    $email = mysqli_escape_string( $mysqli ,$_POST["email"]);
    $query = "SELECT * FROM users WHERE email='$email' ";
    $result = $mysqli->query($query);
    $count = mysqli_num_rows($result);

    if ($count > 0){
      foreach ($result as $row);
      if ($_POST['email'] == $row['email'] AND
          crypt($_POST['password'], $row['password']) == $row['password']) {
            $_SESSION = array(
              'login' => true,
              'user'  => array(
                'uuid'  => $row['uuid'],
                'name'  => $row['username'],
                'email'  => $row['email'],
                'ver_league'  => $row['ver_league'],
                'ver_email'  => $row['ver_email'],
              )
            );
            if ($row["ver_league"] == true){
              include $_SERVER["DOCUMENT_ROOT"]."/source/php/api.php";

              $Summoner = apicall("summoner_by_uuid",$_COOKIE["region"],$row["league_puuid"],0);
              $LiveVersion = apicall("liveversion",0,0,0)[0];
              $avatar = "https://ddragon.leagueoflegends.com/cdn/$LiveVersion/img/profileicon/".$Summoner['profileIconId'].".png";

              $_SESSION["user"]["avatar"] = $avatar;
              $_SESSION["league"]["uuid"] = $row["league_puuid"];
              $_SESSION["league"]["region"] = $row["league_region"];
              $_SESSION["league"]["id"] = $Summoner["id"];
              $_SESSION["league"]["accountId"] = $Summoner["accountId"];
              $_SESSION["league"]["sumName"] = $Summoner["name"];
            }

            if (!empty($_SERVER['QUERY_STRING'])){
  					$redirect = substr ($_SERVER['QUERY_STRING'], 9);
  						header ('Location: '.$redirect.'');
  					} else {
  					 header ('Location: http://' . $_SERVER['HTTP_HOST'] . '');}
          } else { $errorMsg = $CONTENT["email-password-dont-match"]; }
        } else { $errorMsg = $CONTENT["email-password-dont-match"]; }
  } else { $errorMsg = $CONTENT["empty_form"]; }
} ?>
