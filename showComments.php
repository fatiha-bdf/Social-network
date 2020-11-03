<?php
include_once('./classes/DB.php');
include_once('./classes/LOGIN.php');
include_once('./classes/IMAGE.php');

if (LOGIN::isLogged()) {
  $user_id = LOGIN::isLogged();
}


if (isset($_POST['photo'])) {
  $photo = $_POST['photo'];
  IMAGE::showComments($photo);
} else {
  echo 'Error: please try again';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <style>
    .listcomments {
      height: 100px;
      overflow: auto;
    }
    
    li {
      list-style: none;
    }
    
  </style>
</head>
<body>
  
</body>
</html>