<form method="post" id="search-bar">
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
  function getCookie(cname) {
  var name = cname + "=";
  var decodedCookie = decodeURIComponent(document.cookie);
  var ca = decodedCookie.split(';');
  for(var i = 0; i <ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}
function cookie_accept(){
  createCookie("okCookie",true,9999);
  document.getElementById("okCookie").style.display='none';
}
function change_region(region){
  createCookie("region",region,9999);
  location.reload();
}
function change_lang(lang){
  createCookie("lang",lang,9999);
  location.reload();
}
function change_darkmode(darkmode){
  if (darkmode == "settodarkmode"){
    createCookie("darkmode","true",9999);
    location.reload();
  } else {
    createCookie("darkmode","false",-1);
    location.reload();
  }
}

  function delete_recent_searches(user){
    var list = JSON.parse(getCookie('<?php echo"SumSearches".$regionName; ?>'));
    list.splice( list.indexOf(user), 1 );
    createCookie("<?php echo"SumSearches".$regionName; ?>",JSON.stringify(list),9999);
  }
  function recent_searches() {
    document.getElementById("recent-searches").classList.toggle("show");
    document.getElementById("search-summoner").classList.toggle("show");

    document.getElementById("recent-searches").style.display='block';
    document.getElementById("search-summoner").setAttribute("style", "border-bottom-left-radius: 0;");
    }
    // Close window
    window.onclick = function(event) {
    if (!event.target.matches('.dropbtn')) {
      var dropdowns = document.getElementsByClassName("dropdown-content");
      var i;
      for (i = 0; i < dropdowns.length; i++) {
        var openDropdown = dropdowns[i];
        if (openDropdown.classList.contains('show')) {
          openDropdown.classList.remove('show');
          document.getElementById("recent-searches").style.display='none';
          document.getElementById("search-summoner").setAttribute("style","none");
        }
      }
    }
    }
  </script>
  <input <?php if (!empty($_COOKIE["SumSearches".$regionName]) && $_COOKIE["SumSearches".$regionName] != "[]")
  {echo 'onfocus="recent_searches()" ';} ?>
  class="dropbtn" type="text" name="summoner" id="search-summoner" placeholder="<?php echo $CONTENT["search-summoner"];?>" autocomplete="off"></imput>
  <div id="recent-searches" class="dropdown-content">
    <?php
    if (!empty($_COOKIE["SumSearches".$regionName])){
    foreach (json_decode($_COOKIE["SumSearches".$regionName]) as $key) {
      echo '<div>
      <a href="http://'.$_SERVER["HTTP_HOST"].'/summoner/?id='.$key.'"><div>'.$key.'</div></a>
      <button onclick="delete_recent_searches(user=\''.$key.'\')"><i class="fas fa-times"></i></button>
      </div>';
      }
    }?>
  </div>

  <input type="checkbox" id="region-dropdwn"/>
  <label for="region-dropdwn">
    <div id="search-region"><?php echo $regionName;?></div>
    <div id="region-dropdwn-menu">
      <h3><?php echo $CONTENT["select-region"];?>:</h3>
      <?php
      foreach ($regions as $row ) {
        if ($_COOKIE["region"] != $row["id"]){
          echo '<button onclick="change_region(region=\''.$row["id"].'\')"> '.$row["name"].'</button>';}
      }
       ?>
    </div>
  </label>
  <button type="submit">
    <i class="fas fa-search"></i>
  </button>
</form>
