<?php
  if (!empty($_COOKIE["lang"])){
    $CONTENT = json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"]."/source/header/lang/".$_COOKIE["lang"].".json"),true);
  } else {
    $CONTENT = json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"]."/source/header/lang/default.json"),true);
  }
  include $_SERVER["DOCUMENT_ROOT"]."/source/header/search.php";
  $regions = json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"]."/source/loldata/regions.json"), true);
  $regionName = $regions[$_COOKIE["region"]]["name"];
 ?>
<noscript>
  <div>
    <div>
      <h3>ERROR: JavaScript is blocked </h3>
      <p>
        <?php echo $CONTENT["noscript"];?>
      </p>
    </div>
  </div>
</noscript>

<div id="header">
  <label for="main-checkbox" id="main-menu-btn">
    <img src="http://<?php echo $_SERVER['HTTP_HOST']?>/source/img/icons/menu.png"></img>
  </label>
  <a id="logo" href="http://<?php echo $_SERVER['HTTP_HOST']?>">NPX</a>

  <?php include $_SERVER["DOCUMENT_ROOT"]."/source/header/searchbar.php";
        include $_SERVER["DOCUMENT_ROOT"]."/source/header/login_user.php";?>
</div>

<input type="checkbox" id="main-checkbox"/>
<div id="main-menu">
  <nav>
    <a href="http://<?php echo$_SERVER['HTTP_HOST'];?>">
      <div class="box">
        <img src="http://<?php echo $_SERVER['HTTP_HOST']?>/source/img/icons/home.svg" />
        <div><?php echo $CONTENT["home"];?></div>
      </div>
    </a>
    <a href="http://<?php echo$_SERVER['HTTP_HOST'];?>/toplist">
      <div class="box" style="display: none;">
        <img src="http://<?php echo $_SERVER['HTTP_HOST']?>/source/img/icons/toplist.svg" />
        <div><?php echo $CONTENT["toplist"];?></div>
      </div>
    </a>
	  <a href="http://<?php echo$_SERVER['HTTP_HOST'];?>/stats">
      <div class="box" style="display: none;">
        <img src="http://<?php echo $_SERVER['HTTP_HOST']?>/source/img/icons/stats.svg" />
        <div><?php echo $CONTENT["statistics"];?></div>
	       <span style="font-size: 14px; color: red; font-weight: 600; vertical-align: top;
         position: relative; left: 16px;">ALPHA</span>
     </div>
   </a>
	 <a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/summoner/<?php if (isset($_SESSION['login'])){ echo '?region='.$regionName.'&id='.$_SESSION['league']['sumName'];}?>">
    <div class="box">
      <img src="http://<?php echo $_SERVER['HTTP_HOST']?>/source/img/icons/summoner.svg" />
      <div><?php echo $CONTENT["summoner"];?></div>
    </div>
  </a>
	<a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/match/
		<?php if (isset($_SESSION['login'])){ echo '?region='.$regionName.'&id='.$_SESSION['league']['sumName'];}?>">
    <div class="box">
      <img src="http://<?php echo $_SERVER['HTTP_HOST']?>/source/img/icons/livematch.svg" />
      <div><?php echo $CONTENT["livematch"];?></div>
    </div>
  </a>

  </nav>
  <div id="main-menu-footer">

  <div id="main-menu-options">
    <div>
    <?php echo $CONTENT["darkmode"];?>
    <label class="toggle" onclick="change_darkmode('<?php echo $darkmode;?>')">
            <input id="toggleswitch" type="checkbox" name="toggle_theme"
            <?php if (isset($_COOKIE["darkmode"])){echo "checked";}?>>
            <span class="roundbutton"></span>
    </label>
    </div>
    <div>
      <?php echo $CONTENT["region"];?>
      <input type="checkbox" id="main-menu-region-dropdwn"></input>
      <label for="main-menu-region-dropdwn">
        <div id="region-btn"><?php echo  $regionName;?> <i class="fas fa-caret-down"></i></div>
        <div id="region-dropdwn-content">
          <?php
          foreach ($regions as $row ) {
            if ($_COOKIE["region"] != $row["id"]){
              echo '<button onclick="change_region(region=\''.$row["id"].'\')"> '.$row["name"].'</button>';}
          }
           ?>
        </div>
      </label>
    </div>
    <div>
      <?php echo $CONTENT["language"];?>
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
	<div class="links">
		&nbsp;<a  href="http://<?php echo$_SERVER['HTTP_HOST'];?>/imprint"><?php echo $CONTENT["imprint"];?></a> &nbsp;
		&nbsp;<a  href="http://<?php echo$_SERVER['HTTP_HOST'];?>/privacy-policy"><?php echo $CONTENT["privacy-policy"];?></a> &nbsp;
		&nbsp;<a  href="http://<?php echo$_SERVER['HTTP_HOST'];?>/updates"><?php echo $CONTENT["updates"];?></a> &nbsp;
	</div>
	<div class="copyright" >&copy; 2017-2019 Nopex.net</div>
</div>
</div>

<?php
include $_SERVER["DOCUMENT_ROOT"]."/source/header/page-notification.php";

if (empty($_COOKIE["okCookie"])){
  include $_SERVER["DOCUMENT_ROOT"]."/source/header/okCookie.php";
}?>
