<?php
include $_SERVER["DOCUMENT_ROOT"]."/source/php/main.php";
$CONTENT = json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"]."/account/login/lang/".$_COOKIE["lang"].".json"),true);
include $_SERVER["DOCUMENT_ROOT"]."/account/forms/login.php";?>
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
    <div id="login-box">
      <form action="./<?php if (!empty($_GET['redirect'])){echo "?".$_SERVER['QUERY_STRING'];}?>" method="post">
        <h4><?php echo $CONTENT["login"]; ?></h4>
        <?php if (!empty($errorMsg)){
          echo '<div id="error-box">'.$errorMsg.'</div>';
        }?>
        <div>
          <i class="fas fa-envelope"></i>
          <input type="email" name="email" placeholder="<?php echo $CONTENT["email"]; ?>"></input>
        </div>
        <div>
          <i class="fas fa-unlock"></i>
          <input type="password" name="password" placeholder="<?php echo $CONTENT["password"]; ?>"></input>
        </div>
        <button><?php echo $CONTENT["sign-in"]; ?></button>
      </form>
        <div id="alternate-btn">
          <a href="http://<?php echo $_SERVER['HTTP_HOST'];?>/account/create">
            <div> <?php echo $CONTENT["create-account"]; ?></div>
          </a>
        </div>

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
          <div id="forgotten-password">
            <a href="http://<?php echo $_SERVER['HTTP_HOST'];?>/account/login/reset-password"><?php echo $CONTENT["forgotten-password"]; ?></a>
          </div>
        </div>

    </div>
  </body>
</html>
