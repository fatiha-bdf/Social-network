<?php
include_once('./classes/DB.php');
include_once('./classes/LOGIN.php');
include_once('./classes/IMAGE.php');

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
  <div class="containerlog">
    <div class="row center-xs center-sm center-md center-lg middle-xs middle-sm middle-md middle-lg">
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="gallery">
        <?php
        if (LOGIN::isLogged()) {
          IMAGE::display_public_image_comment();
        }
        else {
          IMAGE::display_public_image();
        }
        ?>
        </div>
         <?php
        if (!(DB::query("SELECT * from gallery", array()))) {
        $input = " <section id='showcase'>
        <div class='container'>
          <div class='row center-xs center-sm center-md center-lg middle-xs middle-sm middle-md middle-lg'>
            <div class='col-xs-9 col-sm-9 col-md-9 col-lg-9 showcase-content'>
              <h1>Welcome to <span class='primary-text'>Camagru</span></h1>
              <p>Build your world with images</p>
            </div>
          </div>
        </div>
      </section>";
        }
        else {
          $input = "<div style='background-color: #ffff0g;  border-color: #000000; height: 550px'>
            </div>";
        }
        echo $input;
        ?>
        <!-- </div>
        <div style="background-color: #ffff0g;  border-color: #000000; height: 590px">
        </div> -->
      </div>
    </div>
  </div>
  <script src="javascript/gallery.js"></script>
</body>
</html>