<div id="login-user-box">
<?php
if (isset($_SESSION['login'])) {
  if(!empty($_SESSION['user']['avatar'])){
    $avatar = '<img src="'.$_SESSION['user']['avatar'].'" class="avatar" />';
  } else {
    $avatar = '<div class="avatar" style="background-color: #2d2d2d; display: inline-block;"></div>';
  }
   echo '
   <div id="user-main-menu">
     '.$avatar.'
     <input type="checkbox" id="main-user-dropdwn">
     <label for="main-user-dropdwn">
     <div class="dropdown-btn">'. $_SESSION['user']['name'].'
     <span class="dropdwnpfeil">^</span></div>
     </label>
       <div id="main-user-dropdwn-menu">
         <ul>
         <a href="http://'.$_SERVER['HTTP_HOST'].'/account"><li><i class="fas fa-user-circle"></i>
                  '.$CONTENT["account"].'</li></a>
         <a href="http://'.$_SERVER['HTTP_HOST'].'/account/settings"><li><i class="fas fa-cog"></i>
                  '.$CONTENT["settings"].'</li></a>
         <a href="http://'.$_SERVER['HTTP_HOST'].'/account/logout?redirect=http://'.$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'].'"><li><i class="fas fa-sign-out-alt"></i>
                  '.$CONTENT["logout"].'</li></a>
         <ul>
       </div>
   </div>
   ';
} else {
  echo '
  <div id="login-box" style="display: none;>
  <a
  href="http://'.$_SERVER['HTTP_HOST'].'/account/login?redirect=http://'.$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'].'">'.$CONTENT["sign-in"].'</a>
  |
  <a
  href="http://'.$_SERVER['HTTP_HOST'].'/account/create">'.$CONTENT["sign-up"].'</a>
  </div>
  ';
}
  ?>
</div>
