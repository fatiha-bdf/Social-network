<?php
include_once('./classes/DB.php'); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Camagru</title>
  <link rel="stylesheet" href="style/main.css?version=51" type="text/css">
  <link rel="stylesheet" href="style/flexboxgrid.css?version=51" type="text/css">
  <link rel="stylesheet" href="style/all.css?version=51" type="text/css">
  <style type="text/css" ></style>
  <script src="javascript/ajax.js"></script>
  <script src="javascript/restrict.js"></script>
</head>

<body>
<!-- ############################################################################################################ -->
  
<header id="main-header">
    <div class="container">
      <div class="row end-sm end-md end-lg center-xs middle-xs middle-sm middle-md middle-lg">
        <div class="col-xs-10 col-sm-2 col-md-2 col-lg-2">
          <a href="http://localhost:8080/camagru/"><img src="img/logo.png"></a>
        </div>
        <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10">
        </div>
      </div>
    </div>
  </header>

<!-- ############################################################################################################ -->

<section id="showcaselog">
    <div class="containerlog">
      <div class="row center-xs center-sm center-md center-lg middle-xs middle-sm middle-md middle-lg">
        <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9 showcase-contentlog">
        <?php
          if (isset($_GET['u']) && isset($_GET['e']) && isset($_GET['p'])) {
          $username = $_GET['u'];
          $email = $_GET['e'];
          $password = $_GET['p'];
          $db_username = DB::query('SELECT username FROM users where password=:password', array(":password"=>$password))[0]['username'];
          if($username == $db_username) {
            DB::query("UPDATE users SET confirmed='yes' where username=:username", array(':username'=>$username));
            echo "<h3>Welcome you can now Login to you account with your email and password</h3>
            <a href='http://localhost:8080/camagru/login.php'>Click here to Log in</a>";
          }
          else {
            echo 'An error occured, you may not be allow to access this page';
          }
        }
        ?>
        </div>
      </div>
    </div>
  </section>

<!-- ############################################################################################################ -->
<?php
  require_once 'footer.php';
?>
</body>
</html>