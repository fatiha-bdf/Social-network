<?php
include_once('./classes/DB.php');
include_once('./classes/LOGIN.php');
include_once('./classes/POST.php');
include_once('./classes/LIKE.php');

if (LOGIN::isLogged()) {
  $user = LOGIN::isLogged();
  if (!(DB::query("SELECT * from gallery where user_id=:user", array(':user'=>$user)))) {
    header("location:/camagru/webcam.php");
  }
} 
else {
  header("location:/camagru/");
}



$loggeduser = LOGIN::isLogged();
$username = "";

if (isset($_GET['username'])) { //check if the username parameter has been passed to the profile
  $query = 'SELECT username FROM users WHERE username=:username';
  $param = array(':username'=>$_GET['username']);
  if (DB::query($query, $param)) {
    $username = DB::query($query, $param)[0]['username'];
    echo $username . '\'s profile'."<hr/></br/>";

    if (isset($_POST['post'])) {
      $query = 'SELECT id FROM users WHERE username=:username';
      $param = array(':username'=>$_GET['username']);
      $user = DB::query($query, $param)[0]['id'];
      $postbody = $_POST['postbody'];

      POST::createpost($postbody, $loggeduser, $user);
    }


    if (isset($_GET['postid'])) {
      LIKE::likepost($loggeduser, $_GET['postid']);
    }
    $posts = POST::displaypost($loggeduser, $username);
  }
  else {
    die('User not found');
  }
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
  <script src="javascript/ajax.js"></script>
  <script src="javascript/restrict.js"></script>
  <style>
  #footer {
  color: white;
  background-color: rgb(82, 240, 187);
  /* position: relative; bottom: 0px; left: 0; right: 0; */
  clear: both;
    position: relative;
    }
  </style>
</head>

<body>

<!-- ############################################################################################################ -->

<?php
require_once 'gallery.php';
?>
<footer id="footer">
<div class="container">
  <div class="row center-xs center-sm center-md center-lg">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <p>Copyright &copy; 2019 | fboudyaf</p>
    </div>
  </div>
</div>
</footer>

<!-- ############################################################################################################ -->

</html>


