<?php
if (isset($_SESSION['login'])){
  if ($_SESSION["user"]["ver_email"] != true){
    echo'
    <div class="error-notification">
      '.$CONTENT['ver-email'].'
      <a href="http://'.$_SERVER["HTTP_HOST"].'/account/create/email-verification">'.$CONTENT['ver-email-link'].'</a>
    </div>';
  } else if ($_SESSION["user"]["ver_league"] != true){
    echo'
    <div class="error-notification">
      '.$CONTENT['ver-league'].'
      <a href="http://'.$_SERVER["HTTP_HOST"].'/account/create/add-league-account">'.$CONTENT['ver-league-link'].'</a>
    </div>';
  }
}
?>
