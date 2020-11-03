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

if (isset($_POST['tomove']))  {
  $photo = $_POST['tomove'];
  echo $photo;
  if (empty($photo)) {
    echo 'ERROR please try again';
    exit();
  }
  $dir = 'file:///Users/fboudyaf/Desktop/mamp/apache2/htdocs/camagru/img/gallery/';
  IMAGE::movetogallery($photo, $dir, $logged_id);
  exit();
}
else {
  echo 'Error';
}
?>
