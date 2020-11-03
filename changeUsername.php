<?php
include('classes/DB.php');
include('./classes/LOGIN.php');

if (!LOGIN::isLogged()) {
  header("location:/camagru/login.php");
}

if (isset($_POST['u'])) {
  $userid = LOGIN::isLogged();
  $query = 'SELECT password from users where id=:userid';
  $param = array(':userid'=>$userid);
  $dbpass = DB::query($query, $param)[0]['password'];
  $pass = $_POST['p'];
  $newUsername = $_POST['u'];
  
  if (password_verify($pass, $dbpass)) {
    $query = 'SELECT username FROM users WHERE username=:username';
    $param = array(":username"=>$newUsername);
    if(!DB::query($query, $param)) 
    {
      $query = 'UPDATE users set username=:newUsername where id=:userid';
      $param = array(':newUsername'=>$newUsername, ':userid'=>$userid);
      DB::query($query, $param);
      echo 'changed';
      exit();
    }
    else {
      echo 'Username already exists';
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
  function changeUsernamee() {
    var u = document.getElementById('newUsername').value
    var p = document.getElementById('pass').value
    var status = document.getElementById("status")
    if(u == "" || p == "") {
      status.innerHTML = "Please fill out all of the form data";
    }
    else if (u.lenght < 5) {
      status.innerHTML = "Username must be at least 5 characters";      
    } 
    else {
      var ajax = ajaxObj("POST", "changeUsername.php");
        ajax.onreadystatechange = function() {
        if(ajaxReturn(ajax) == true) {
          if(!ajax.responseText.includes('changed')){
            status.innerHTML = ajax.responseText;
          } else {
            document.querySelector('.showcase-contentlog').innerHTML = 'Your username is updated'
          }
        }
      }
      ajax.send("u="+u+"&p="+p);
    }
    if (document.getElementById('newUsername')) {
      document.getElementById('newUsername').value = ''
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
            <form name="changeUsername" id="changeUsername" onsubmit="return false;">
            <input id="newUsername" type="text" name="newUsername" placeholder="New Username" onkeyup="restrict('newUsername')" maxlength="88">
            <br><hr>
            <input id="pass" type="password" name="password" placeholder="Password" maxlength="16">
            <br><hr>
            <button id="confirmBtn" onclick="changeUsernamee()">Change Username</button>
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