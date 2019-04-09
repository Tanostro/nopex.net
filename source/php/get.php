<?php
  function region(){
    if (!empty($_GET['region'])){
      switch ($_GET['region']) {
        case "euw":
          $region = "euw1";
          break;
        case "eun":
          $region = "eun1";
          break;
        case "na":
          $region = "na1";
          break;
        case "br":
          $region = "br1";
          break;
        case "jp":
          $region = "jp1";
          break;
        case "kr":
          $region = "kr";
          break;
        case "lan":
          $region = "la1";
          break;
        case "las":
          $region = "la2";
          break;
        case "oc":
          $region = "oc1";
          break;
        case "tr":
          $region = "tr1";
          break;
        case "ru":
          $region = "ru";
          break;
        default:
          // code...
          break;
      }
    } else {
      return Null
    }
  }

  function sumId(){
    if (!empty($_GET["id"])){
      return str_replace(" ", "%20",$_GET['id']);
    }
  }
 ?>
