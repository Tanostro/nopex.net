<?php
include $_SERVER["DOCUMENT_ROOT"]."/source/php/main.php";
$CONTENT = json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"]."/account/create/lang/".$_COOKIE["lang"].".json"),true);
include $_SERVER["DOCUMENT_ROOT"]."/account/forms/ver-email.php";

if (empty($_SESSION['login'])){
  die(header('Location: http://' . $_SERVER['HTTP_HOST'] . '/account/login?redirect=http://'.$_SERVER['HTTP_HOST'].'/account/create/email-verification'));
}

if ($_SESSION['user']['ver_email'] == true){
  die(header('Location: http://' . $_SERVER['HTTP_HOST']));
}

if (!empty($_GET['resend'])){
  if ($_GET['resend'] == true){
    $mysqli = @new mysqli('############', '############', '############', '############');
    if ($mysqli->connect_error){
      $errorMsg = $CONTENT["database_connection_error"];
    }
        $uuid = $_SESSION['user']['uuid'];
        $query = "SELECT email_code FROM verification WHERE uuid='$uuid' ";
        $result = $mysqli->query($query);
        foreach ($result as $row);
        $verCode = $row["email_code"];
        $email = $_SESSION['user']['email'];
        require("../../mail/ver_email.php");
        require('../../mail/send_email.php');
    }
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
     <div id="email-ver-box">
       <form action="" method="post">
         <h4><?php echo $CONTENT["email-ver"];?></h4>

         <?php
         if (!empty($_GET['resend'])){
           if ($_GET['resend'] == true){
           echo
           '<div id="info">
             '.sprintf($CONTENT["email-ver-info"], $_SESSION['user']['email']).'
           </div>';}
         }?>

         <?php if (!empty($errorMsg)){
           echo '<div id="error-box">'.$errorMsg.'</div>';
         }?>
         <div>
           <input type="text" name="ver-code" maxlength="6" placeholder="<?php echo $CONTENT["verification-code"];?>">
           </input>
         </div>

         <button><?php echo $CONTENT["continue"];?></button>
       </form>

       <a id="resend-email" href="http://<?php echo $_SERVER['HTTP_HOST'];?>/account/create/email-verification?resend=true">
         <div><?php echo $CONTENT["resend-email"];?></div></a>

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
