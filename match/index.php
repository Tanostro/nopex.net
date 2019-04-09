<?php
if (!empty($_GET["id"])){
  include $_SERVER["DOCUMENT_ROOT"]."/match/php/activematch.php";
} else {
  include $_SERVER["DOCUMENT_ROOT"]."/match/php/noactivematch.php";
}
 ?>
