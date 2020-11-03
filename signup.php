<?php
include('classes/DB.php');
include('./classes/LOGIN.php');

if (LOGIN::isLogged()) {
  $logged_id = LOGIN::isLogged();
  $logged_username = DB::query('SELECT username FROM users WHERE id=:logged_id', array(':logged_id'=>$logged_id))[0]['username'];
  header("location:/camagru/profile.php");
}

if (isset($_POST['u'])) {
  $username = htmlspecialchars($_POST['u']);
  $email = htmlspecialchars($_POST['e']);
  $password = htmlspecialchars($_POST['p']);

  $query = 'SELECT username FROM users WHERE username=:username';
  $param = array(":username"=>$username);
  if (!DB::query($query, $param))
  {
      if (filter_var($email, FILTER_VALIDATE_EMAIL))
      {
        $query = 'SELECT username FROM users WHERE email=:email';
        $param = array(":email"=>$email);
        if(!DB::query($query, $param)) 
        {
          $p_hash = password_hash($password, PASSWORD_BCRYPT);
          $query = "INSERT INTO `users` (`username`, `email`, `password`, `confirmed`, `allow_notif`) VALUES (:username, :email, :password, 'no', 'no')";
          $param = array(":username"=>$username, ":email"=>$email, ":password"=>$p_hash);
          DB::query($query, $param);
          $from = 'fatiha@camagru.com';
          $subject = "Validation de votre d'inscription";
          // $headers = "Content-type: text/html; charset=utf-8\r\n";
          $message = '<!DOCTYPE html>
                    <html>
                    <head>
                    <meta charset="UTF-8">
                    <title>Camagru</title>
                    </head>
                    <body style="margin:0px; font-family:Tahoma, Geneva, sans-serif;">
                    <div style="padding:10px; background:#333; font-size:24px; color:#CCC;">
                    <a href="http://localhost:8080/camagru/"></a>
                    Camagru Account Activation
                    </div>
                    <div style="padding:24px; font-size:17px;">Hello '.$username.',<br /><br />
                    Click the link below to activate your account when ready:<br /><br />
                    <a href="http://localhost:8080/camagru/activation.php?u='.$username.'&e='.$email.'&p='.$p_hash.'">
                    Click here to activate your account now</a><br /><br />
                    Login after successful activation using your:<br />
                    * E-mail Address: <b>'.$email.'</b>
                    </div>
                    </body>
                    </html>';
          $headers = "From: $from\n";
          $headers .= "MIME-Version: 1.0\n";
          $headers .= "Content-type: text/html; charset=iso-8859-1\n";
          if (mail('fatiha.boudyaf@gmail.com', $subject, $message, $headers)){
            echo 'signup_success';
            exit();
          } else {
            echo 'problem sending email';
            exit();
          }
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
  } else {
    echo 'Username already exists';
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
    function signuup(){
      var u = document.getElementById('username').value
      var e = document.getElementById('email').value
      var p1 = document.getElementById('pass1').value
      var p2 = document.getElementById('pass2').value
      var status = document.getElementById("status")
      var validPass = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/
      if(u == "" || e == "" || p1 == "" || p2 == ""){
        status.innerHTML = "Please fill out all of the form data";
      } 
      else if(p1 != p2){
        status.innerHTML = "Password fields do not match";
      } 
      else if (u.lenght < 5) {
          status.innerHTML = 'Username must be at least 5 characters';
      } 
      else if (!p1.match(validPass)) {
          status.innerHTML = 'Password between 6 to 20 characters, at least one numeric digit, one uppercase and one lowercase letter', 'error'
      } 
      else {
        var ajax = ajaxObj("POST", "signup.php");
          ajax.onreadystatechange = function() {
          if(ajaxReturn(ajax) == true) {
            if(ajax.responseText.includes('signup_success')){
              window.scrollTo(0,0);
              document.querySelector('.showcase-contentlog').innerHTML = 'Welcome '+u+', you have successfully signed up .. Check your emails and confirm ...'
            }
            else {
              status.innerHTML = ajax.responseText;
            }
          }
        }
        ajax.send("u="+u+"&e="+e+"&p="+p1);
      }
      if (document.getElementById('username')) {
        document.getElementById('username').value = ''
      }
      if (document.getElementById('email')) {
        document.getElementById('email').value = ''
      }
      if (document.getElementById('pass1')) {
        document.getElementById('pass1').value = ''
      }
      if (document.getElementById('pass2')) {
        document.getElementById('pass2').value = ''
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
          <h3>Signup here</h3>
            <form name="signupForm" id="signupForm" onsubmit="return false;">
            <input type="text" id="username" name="username" value="" placeholder="Username" onkeyup="restrict('username')" maxlength="16">
            <br><hr>
            <input id="email" type="text" name="email" placeholder="Email" onkeyup="restrict('email')" maxlength="88">
            <br><hr>
            <input id="pass1" type="password" name="password" placeholder="Password" maxlength="16">
            <br><hr>
            <input id="pass2" type="password" placeholder="Confirm Password" maxlength="16" maxlength="16">
            <br><hr>
            <button id="signupBtn" onclick="signuup()">Create Account</button>
            <!-- <input id="signupBtn" type="submit" name="signup" onclick="signuup()" value="Create Account"> -->
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