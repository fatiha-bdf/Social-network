<?php
include_once('./classes/DB.php');
include_once('./classes/LOGIN.php');
include_once('./classes/IMAGE.php');


if (LOGIN::isLogged()) {
  $logged_id = LOGIN::isLogged();
}
else {
  header("location:/camagru/login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="style/main.css" type="text/css">
  <link rel="stylesheet" href="style/flexboxgrid.css" type="text/css">
  <link rel="stylesheet" href="style/all.css" type="text/css">

  <title>Gallery</title>
</head>
<style type="text/css">
  body{
    font-family: sans-serif;
  }
</style>
<body>
<section id="showcaselog">

  <div class="containerlog">
    <div class="center-xs center-sm center-md center-lg middle-xs middle-sm middle-md middle-lg">
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <img src="img/iconWebcam.png" class="btn" onclick="backtoWebcam()" alt="Go to webcam">
        <div class="gallery">
        <?php 
        if (LOGIN::isLogged()) {
            IMAGE::displaygallery($logged_id);
        }
        ?>
        </div>
        </div>
        <?php
        if (LOGIN::isLogged()) {
          if (!(DB::query("SELECT * from gallery where user_id=:user", array(':user'=>$logged_id)))) {
              $blank = "<div style='background-color: #ffff0g;  border-color: #000000; height: 800px'>
              </div>";
          }
          else {
            $blank = "<div style='background-color: #ffff0g;  border-color: #000000; height: 550px'>
              </div>";
          }
          echo $blank;
        }
        ?>
        <!-- <div style="background-color: #ffff0g;  border-color: #000000; height: 550px">
        </div> -->
      </div>
    </div>
  </div>
  <script src="javascript/gallery.js"></script>
</section>


</body>
</html>