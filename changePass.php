<?php 
include_once('./classes/DB.php'); 
include_once('./classes/LOGIN.php'); 

if (!LOGIN::isLogged()) {
  header("location:/camagru/login.php");
}

if (isset($_POST['p1'])) {
  $userid = LOGIN::isLogged();
  $query = 'SELECT password from users where id=:userid';
  $param = array(':userid'=>$userid);
  
  $oldpass = $_POST['p1'];
  $newpass = $_POST['p2'];
  $dbpass = DB::query($query, $param)[0]['password'];
  
  if (password_verify($oldpass, $dbpass)) {
    $query = 'UPDATE users set password=:newpass where id=:userid';
    $param = array(':newpass'=>password_hash($newpass, PASSWORD_BCRYPT), ':userid'=>$userid);
    DB::query($query, $param)[0]['password'];
    echo 'changed';
    exit();
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
  function changePasss() {
    var p1 = document.getElementById('oldPass').value
    var p2 = document.getElementById('newPass').value
    var p2r = document.getElementById('repeatPass').value
    var status = document.getElementById("status")
    var validPass = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/

    if(p1 == "" || p2 == "" || p2r == "") {
      status.innerHTML = "Please fill out all of the form data"
    }
    else if(p2 != p2r) {
      status.innerHTML = "Passwords do not match"
    }
    // else if (!p1.match(validPass)) {
    //       status.innerHTML = 'Password between 6 to 20 characters, at least one numeric digit, one uppercase and one lowercase letter', 'error'
    // } 
    else {
      var ajax = ajaxObj("POST", "changePass.php");
        ajax.onreadystatechange = function() {
        if(ajaxReturn(ajax) == true) {
          if(!ajax.responseText.includes('changed')){
            status.innerHTML = ajax.responseText;
          } else {
            document.querySelector('.showcase-contentlog').innerHTML = 'Your password is updated'
          }
        }
      }
      ajax.send("p1="+p1+"&p2="+p2+"&p2r="+p2r);
    }
    if (document.getElementById('p1')) {
      document.getElementById('p1').value = ''
    }
    if (document.getElementById('p2')) {
      document.getElementById('p2').value = ''
    }
    if (document.getElementById('p2r')) {
      document.getElementById('p2r').value = ''
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
          <h3>Change password</h3>
            <form name="changePass" id="changePass" onsubmit="return false;">
            <br><hr>
            <input id="oldPass" type="password" name="oldPass" placeholder="Old Password" maxlength="16">
            <br><hr>
            <input id="newPass" type="password" name="newPass" placeholder="New Password" maxlength="16">
            <br><hr>
            <input id="repeatPass" type="password" name="repeatPass" placeholder="Repeat Password" maxlength="16">
            <br><hr>
            <button id="confirmBtn" onclick="changePasss()">Change Password</button>
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

