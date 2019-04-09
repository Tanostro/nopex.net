<?php
include $_SERVER["DOCUMENT_ROOT"]."/source/php/main.php";
$CONTENT = json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"]."/account/login/lang/".$_COOKIE["lang"].".json"),true);
include $_SERVER["DOCUMENT_ROOT"]."/account/forms/set-new-password.php";

if (!empty($_GET)){
  if (isset($_GET["email"]) AND isset($_GET["resetcode"])){
	$mysqli = @new mysqli('############', '############', '############', '############');
    if ($mysqli->connect_error){
      $errorMsg = $CONTENT["database_connection_error"];
    }
      $email = mysqli_escape_string( $mysqli ,$_GET["email"]);
      $query = "SELECT uuid FROM users WHERE email='$email' ";
      $result = $mysqli->query($query);
      $count = mysqli_num_rows($result);
      foreach ($result as $row);

      if ($count > 0){
        $uuid = $row["uuid"];
        $query = "SELECT email_reset_code FROM verification WHERE uuid='$uuid' ";
        $result = $mysqli->query($query);
        foreach ($result as $row);

        if ( $row["email_reset_code"] != $_GET["resetcode"]){
          die(header('Location: http://'.$_SERVER['HTTP_HOST']));
        }

      } else {
        die(header('Location: http://'.$_SERVER['HTTP_HOST']));
      }
  } else {
    die(header('Location: http://'.$_SERVER['HTTP_HOST']));
  }
} else {
  die(header('Location: http://'.$_SERVER['HTTP_HOST']));
}
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
    </script>
  </head>
  <body>
    <div id="reset-email-box">
      <form action="" method="post">
        <h4><?php echo $CONTENT["reset-password"];?></h4>

        <?php
        if (!empty($_GET["send"])){
          echo '<div id="confirm-box">'.$CONTENT["confirm-send-email"].'</div>';
          }
        if (!empty($errorMsg)){
          echo '<div id="error-box">'.$errorMsg.'</div>';
        }?>
        <div>
          <i class="fas fa-unlock"></i>
          <input type="password" name="password" placeholder="<?php echo $CONTENT["new-password"];?>">
          </input>
        </div>
        <div>
          <i class="fas fa-unlock"></i>
          <input type="password" name="password2" placeholder="<?php echo $CONTENT["confirm-new-password"];?>">
          </input>
        </div>
        <button name="submit"><?php echo $CONTENT["set-new-password"];?></button>
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
