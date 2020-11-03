<?php
include('classes/DB.php');
include('./classes/LOGIN.php');

if (!LOGIN::isLogged()) {
  header("location:/camagru/login.php");
}

if (isset($_POST['e'])) {
  $userid = LOGIN::isLogged();
  $query = 'SELECT password from users where id=:userid';
  $param = array(':userid'=>$userid);
  $dbpass = DB::query($query, $param)[0]['password'];
  $pass = $_POST['p'];
  $newEmail = $_POST['e'];
  
  if (password_verify($pass, $dbpass)) {
    if (filter_var($newEmail, FILTER_VALIDATE_EMAIL))
      {
        $query = 'SELECT username FROM users WHERE email=:email';
        $param = array(":email"=>$newEmail);
        if(!DB::query($query, $param)) 
        {
          $query = 'UPDATE users set email=:newEmail where id=:userid';
          $param = array(':newEmail'=>$newEmail, ':userid'=>$userid);
          DB::query($query, $param);
          echo 'changed';
          exit();
        }
        else {
          echo 'Email already exists';
          exit();
        }
      } 
      else {
        echo 'Email is not valid';
        exit();
      }
  }
  else {
    echo 'Incorrect password';
    exit();
  }
}
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
  <script src="javascript/ajax.js"></script>
  <script src="javascript/restrict.js"></script>

  <script>
  function changeEmaill() {
    var e = document.getElementById('newEmail').value
    var p = document.getElementById('pass').value
    var status = document.getElementById("status")
    if(e == "" || p == "") {
      status.innerHTML = "Please fill out all of the form data";
    }
    else {
      var ajax = ajaxObj("POST", "changeEmail.php");
        ajax.onreadystatechange = function() {
        if(ajaxReturn(ajax) == true) {
          if(!ajax.responseText.includes('changed')){
            status.innerHTML = ajax.responseText;
          } else {
            document.querySelector('.showcase-contentlog').innerHTML = 'Your email is updated'
          }
        }
      }
      ajax.send("e="+e+"&p="+p);
    }
    if (document.getElementById('newEmail')) {
      document.getElementById('newEmail').value = ''
    }
    if (document.getElementById('pass')) {
      document.getElementById('pass').value = ''
    }
  }
  </script>
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
        <nav id="navbar">
          <ul>
            <li><a href="profile.php">Back to your profile</a></li>
          </ul>
        </nav>
        </div>
      </div>
    </div>
  </header>

<!-- ############################################################################################################ -->

<section id="showcaselog">
    <div class="containerlog">
      <div class="row center-xs center-sm center-md center-lg middle-xs middle-sm middle-md middle-lg">
        <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9 showcase-contentlog">
            <span id="status"></span><br>
          <h3>Enter your info here</h3>
            <form name="changeEmail" id="changeEmail" onsubmit="return false;">
            <input id="newEmail" type="text" name="newEmail" placeholder=" New Email" onkeyup="restrict('newEmail')" maxlength="88">
            <br><hr>
            <input id="pass" type="password" name="password" placeholder="Password" maxlength="16">
            <br><hr>
            <button id="confirmBtn" onclick="changeEmaill()">Change Email</button>
            </form>
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