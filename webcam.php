<?php

include_once('./classes/DB.php');
include_once('./classes/LOGIN.php');
include_once('./classes/IMAGE.php');

if (LOGIN::isLogged()) {
  $logged_id = LOGIN::isLogged();
  $logged_username = DB::query('SELECT username FROM users WHERE id=:logged_id', array(':logged_id'=>$logged_id))[0]['username'];
}
else {
  header("location:/camagru/login.php");
}


if (isset($_POST['snap']))  {
  $snap = $_POST['snap'];
  $filter = $_POST['filter'];
  if (empty($snap)) {
    echo 'ERROR please try again';
    exit();
  }
  $timestamp = mktime();
  $dir = 'file:///Users/fboudyaf/Desktop/mamp/apache2/htdocs/camagru/img/editor/'; // pour stock images
  $file = $logged_username.'_'.$timestamp.'.png';
  $filename = $dir.$file;
  $parts = explode(',', $snap);
  $data = $parts[1];
  $data = str_replace(' ','+',$data);
  $data = base64_decode($data);
  file_put_contents($filename, $data);
	if ($filter != 'nofilter') {
    $under = imagecreatefrompng($filename);
    $over = imagecreatefrompng($filter);
    $width_under = getimagesize($filename)[0];
    $height_under = getimagesize($filename)[1];
    $width_over = getimagesize($filter)[0];
    $height_over = getimagesize($filter)[1];
    if (strstr($filter, 'cadre')) {
      // si le filtre est un cadre, alors utiliser la fonction imagecopyresmpled car elle etire le filtre vers les extremites
      imagecopyresampled ($under, $over, 0, 0, 0, 0, $width_under, $height_under, $width_over, $height_over);
    }
    else {
      imagecopymerge_alpha($under, $over, 0, 0, 0, 0, $width_over, $height_over,100);
    }
    imagepng($under, $filename);
  }
  IMAGE::saveimage($file, $dir, $logged_id);
  exit();
}
function imagecopymerge_alpha($dst_im, $src_im, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h, $pct){
  // using thisinstead of copymerge() to create a transparent background
  $cut = imagecreatetruecolor($src_w, $src_h);
  // copying relevant section from background to the cut resource
  imagecopy($cut, $dst_im, 0, 0, $dst_x, $dst_y, $src_w, $src_h);
  // copying relevant section from watermark to the cut resource
  imagecopy($cut, $src_im, 0, 0, $src_x, $src_y, $src_w, $src_h);
  // insert cut resource to destination image
  imagecopymerge($dst_im, $cut, $dst_x, $dst_y, 0, 0, $src_w, $src_h, $pct);
}
require_once 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Camagru</title>
  <link rel="stylesheet" href="style/main.css" type="text/css">
  <link rel="stylesheet" href="style/flexboxgrid.css" type="text/css">
  <link rel="stylesheet" href="style/all.css" type="text/css">
  <style type="text/css" ></style>
  <script src="javascript/gallery.js"></script>
  <script src="javascript/ajax.js"></script>
  <script src="javascript/restrict.js"></script>
</head>
<body>
    <div class="containerlog">
      <div class="row center-xs center-sm center-md center-lg middle-xs middle-sm middle-md middle-lg">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 showcase-contentlog">
        <img src="img/iconGallery.png" class="btn" onclick="gotoGallery()" alt="back to gallery">
        <br><br>
        <div class="videoObj">
          <video id="videoElmt" autoplay="true" width="650" height="500"></video>
        </div>
        <div>
        <canvas id="snapCanvas" class="image"></canvas>
        </div>
        <div id="display"> </div>
        <img id="snap" class="snap"/>
        <h1 id="clickFilterInstruction">Save or Click bellow to create your image</h1>
        <div id="saveortakenew">
          <button id="saveBtn" class="btn">Save your Picture</button>
          <button id="captureNew" class="btn">Take a new Photo</button>
        </div>
        <img src="img/iconCamera.png" class="btn" id="capture" alt="">
        <br>
        <input id="fileSelect" type="file" onchange="handleFiles(this.files); return false;"  accept=".png" capture="camera">
        <span id="error"></span>
        <br><br>
        <div id="filters">
          <ul id='liste1'>
            <li><img id="glasses" src="img/filter/glasses.png" class="filter"></li>
            <li><img id="cat" src="img/filter/cat-bounce.png" class="filter"></li>
            <li><img id="mustache" src="img/filter/mustache.png" class="filter"></li>
            <li><img id="rainbow" src="img/filter/rainbow.png" class="filter"></li>
            <li><img id="cadre" src="img/filter/cadre.png" class="filter"></li>
            <li><img id="cadre2" src="img/filter/cadre2.png" class="filter"></li>
            <li><img id="banane" src="img/filter/banane.gif" class="filter"></li>
          </ul>
        </div>
          <?php
          if (LOGIN::isLogged()) {
            IMAGE::displayuserimage($logged_id);
          }
          ?>
        <canvas id="resizedCanvas" ></canvas>
        </div>
        </div>
        <div style="background-color: #ffff0g;  border-color: #000000; height: 230px">
        </div>
      </div>
    </div>
    <br>
  <?php require_once 'footer.php';
  ?>
  <script src="javascript/webcam.js"></script>
</body>
</html>