<?php
if (!empty($_GET["id"])){
  include $_SERVER["DOCUMENT_ROOT"]."/summoner/php/summoner.php";
} else {
  include $_SERVER["DOCUMENT_ROOT"]."/summoner/php/nosummoner.php";
}
 ?>
