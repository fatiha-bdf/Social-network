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

if (isset($_POST['todelete']))  {
  $photo = $_POST['todelete'];
  if (empty($photo)) {
    echo 'ERROR please try again';
    exit();
  }
  IMAGE::deleteimage($photo);
}
else {
  echo 'Error';
}
?>
