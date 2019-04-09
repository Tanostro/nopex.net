<?php
// SessionHandler
if (empty($_SESSION)){
session_cache_expire(315360000);
session_start();
session_regenerate_id();
}

// Site-availablety
include $_SERVER["DOCUMENT_ROOT"]."/source/site-unavailable/status.php";
if ($online != true){
  $content = file_get_contents($_SERVER["DOCUMENT_ROOT"]."/source/site-unavailable/index.php");
  die ($content);
}
// Region
if (empty($_COOKIE["region"])){
  setcookie("region", "euw1", time()+315360000, '/', NULL, 0);
  $_COOKIE["region"] = "euw1";
}
// LanguageHandler
if (!empty($_COOKIE["lang"])){
  $data = json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"]."/source/languages.json"),true);
  $LANGUAGE = $data[$_COOKIE["lang"]]["name"];
  unset($data);
} else {
  setcookie("lan", "en", time()+315360000, '/', NULL, 0);
  $_COOKIE["lang"] = "en"; $LANGUAGE = "Deutsch";
 }
?>
