<?php
include_once('./classes/DB.php');
include_once('./classes/LOGIN.php');
include_once('./classes/IMAGE.php');

if (LOGIN::isLogged()) {
  $loggeduser = LOGIN::isLogged();
}
else {
  header("location:/camagru/login.php");
}

if(isset($_POST['liked'])) {
  $photo = $_POST['liked'];
  IMAGE::like($photo, $loggeduser);
} else {
  echo 'Error: please try again';
}
?>