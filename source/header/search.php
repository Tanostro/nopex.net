<?php
  if (!empty($_POST)){
    if (!empty($_COOKIE["region"]) AND !empty($_POST["summoner"])){
      header('Location:http://'.$_SERVER['HTTP_HOST'].'/summoner/?id='.str_replace(" ", "%20",$_POST['summoner']));
    }
  }
?>
