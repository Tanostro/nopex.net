<?php
include $_SERVER["DOCUMENT_ROOT"]."/source/php/main.php";
$CONTENT = json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"]."/account/create/lang/".$_COOKIE["lang"].".json"),true);
include $_SERVER["DOCUMENT_ROOT"]."/account/forms/ver-league.php";

if (empty($_SESSION['login'])){
  die(header('Location: http://' . $_SERVER['HTTP_HOST'] . '/account/login?redirect=http://'.$_SERVER['HTTP_HOST'].'/account/create/add-league-account'));
}

if ($_SESSION['user']['ver_email'] == false){
  die(header('Location: http://' . $_SERVER['HTTP_HOST'].'/account/create/email-verification'));
}
if ($_SESSION['user']['ver_league'] == true){
  die(header('Location: http://' . $_SERVER['HTTP_HOST']));
}

$mysqli = @new mysqli('############', '############', '############', '############');
if ($mysqli->connect_error){
  $errorMsg = $CONTENT["database_connection_error"];
}
$uuid = $_SESSION['user']['uuid'];
$query = "SELECT league_code FROM verification WHERE uuid='$uuid' ";
$result = $mysqli->query($query);
foreach ($result as $row);
if (empty($row["league_code"])){
  $midpart = $uuid + 1000000;
  $backpart = substr(str_shuffle("01234567890123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 6);
  $verCode = "NPX-".$midpart."-".$backpart;
  $query = "UPDATE verification SET league_code='$verCode' WHERE uuid='$uuid' ";
  $mysqli->query($query);
} else { $verCode = $row["league_code"]; }

$regions = json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"]."/source/loldata/regions.json"), true);
$regionName = $regions[$_COOKIE["region"]]["name"];
?>
 <html>
   <head>
     <title>Nopex.net</title>
     <meta charset="utf-8">
     <link rel="shortcut icon" href="http://<?php echo $_SERVER['HTTP_HOST'];?>/source/img/icons/favicon.ico" type="image/x-icon">
     <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
     <link href="http://<?php echo $_SERVER['HTTP_HOST'];?>/source/css/account-light.css" rel="stylesheet" type="text/css">
     <script>
     function createCookie(name,value,days) {
       if (days) {
           var date = new Date();
           date.setTime(date.getTime()+(days*24*60*60*1000));
           var expires = "; expires="+date.toGMTString();
       }
       else var expires = "";
       document.cookie = name+"="+value+expires+"; path=/";
     }
     function change_lang(lang){
       createCookie("lang",lang,9999);
       location.reload();
     }
     function getCookie(cname) {
     var name = cname + "=";
     var decodedCookie = decodeURIComponent(document.cookie);
     var ca = decodedCookie.split(';');
     for(var i = 0; i <ca.length; i++) {
       var c = ca[i];
       while (c.charAt(0) == ' ') {
         c = c.substring(1);
       }
       if (c.indexOf(name) == 0) {
         return c.substring(name.length, c.length);
       }
     }
     return "";
   }
   function change_region(region){
     createCookie("region",region,9999);
     location.reload();
   }
  </script>
   </head>
   <body>
     <div id="league-ver-box">
       <form action="" method="post">
         <h4><?php echo $CONTENT["league-ver"];?></h4>

         <div id="info">
             <?php echo $CONTENT["league-ver-info"];?>
        </div>

         <?php if (!empty($errorMsg)){
           echo '<div id="error-box">'.$errorMsg.'</div>';
         }?>
         <div>
           <div id="code"><?php echo $verCode;?></div>
         </div>
         <div>
           <input type="text" name="sumName" placeholder="<?php echo $CONTENT["summoner-name"];?>">
          </input>
          <input type="checkbox" id="region-dropdwn"/>
          <label for="region-dropdwn">
            <div id="region"><?php echo $regionName;?></div>
            <div id="region-dropdwn-menu">
              <?php
              foreach ($regions as $row ) {
                if ($_COOKIE["region"] != $row["id"]){
                  echo '<button onclick="change_region(region=\''.$row["id"].'\')"> '.$row["name"].'</button>';}
              }
               ?>
            </div>
          </label>
        </div>
         <button name="submit"><?php echo $CONTENT["continue"];?></button>
       </form>

         <div id="language">
           <?php echo $CONTENT["lang"];?>:
           <input type="checkbox" id="language-dropdwn"></input>
           <label for="language-dropdwn">
             <div id="language-btn">
               <?php echo $LANGUAGE ?>
               <i class="fas fa-caret-down"></i></div>
             <div id="language-dropdwn-content">
               <button onclick="change_lang(lang='en')">English</button>
               <button onclick="change_lang(lang='de')">Deutsch</button>
             </div>
           </label>
         </div>

     </div>
   </body>
 </html>
