<?php
include_once('./classes/DB.php');
include_once('./classes/LOGIN.php');
include_once('./classes/LIKE.php');
include_once('./classes/IMAGE.php');

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

  <style type="text/css">
  body{
    font-family: sans-serif;
  }
  </style>
</head>

<!-- ############################################################################################################ -->
  <body>
  <header id="main-header">
    <div class="container">
      <div class="row end-sm end-md end-lg center-xs middle-xs middle-sm middle-md middle-lg">
        <div class="col-xs-10 col-sm-2 col-md-2 col-lg-2">
          <img src="img/logo.png" alt="Logo">
        </div>
        <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10">
          <nav id="navbar">
            <ul>
              <?php 
              if(LOGIN::islogged()) {
                echo "<li><a href='profile.php'>Profile</a></li>
                <img src='img/iconLogout.png' alt='' onclick='logout()' id='logoutBtn' class='icon'>";
              }
              else {
                echo "<li><a href='login.php'>Login</a></li>
                <li><a href='signup.php'>Sign up</a></li>";
              }
              ?>
            </ul>
          </nav>
        </div>
      </div>
    </div>
  </header>
     <script src="javascript/logout.js"></script>

<!-- ############################################################################################################ -->

<?php
  require_once 'publicgallery.php';
  require_once 'footer.php';
?>
<body>
</html>
