<?php
include_once('./classes/DB.php');
include_once('./classes/LOGIN.php');
include_once('./classes/IMAGE.php');

if (LOGIN::isLogged()) {
  $logged_id = LOGIN::isLogged();
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
  h1 {
    text-align: center;
    color: forestgreen;
    margin: 30px 0 50px;
  }

  .gallery {
    margin: 10px 50px;
    display: inline-block;
  }

  .gallery img {
    width: 330px;
    padding: 5px;
    transition: ls;

  }

  .gallery img:hover{
    transform: scale(1.5);
  } 

</style>
<!-- <form action="profile.php?username=<?php echo $username;?>" method="post">
<textarea name="postbody" cols="80" rows="8"></textarea> <p />
<input type="submit" name="post" value="Post">
</form>

<div class="posts"> -->
<body>
  <div class="containerlog">
    <div class="row center-xs center-sm center-md center-lg middle-xs middle-sm middle-md middle-lg">
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="gallery">
        <?php IMAGE::displayuserimage($logged_id);?>
        </div>
      </div>
    </div>
  </div>

</body>
</html>