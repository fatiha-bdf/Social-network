<?php
include('./classes/DB.php');
include('./classes/LOGIN.php');

if (LOGIN::isLogged()) {
  $logged_id = LOGIN::isLogged();
  $logged_username = DB::query('SELECT username FROM users WHERE id=:logged_id', array(':logged_id'=>$logged_id))[0]['username'];
  header("location:/camagru/profile.php");
}


if (isset($_POST['u']) && isset($_POST['u'])){
  $username = htmlspecialchars($_POST['u']);
  $password = htmlspecialchars($_POST['p']);
  $confirmed = DB::query('SELECT confirmed FROM users WHERE username=:username', array(':username'=>$username))[0]['confirmed'];
  $query = 'SELECT username FROM users WHERE username=:username';
  $param = array(":username"=>$username);
  if (DB::query($query, $param)) {
    $query = 'SELECT password FROM users WHERE username=:username';
    $db_password = DB::query($query, $param)[0]['password'];
    if (password_verify($password, $db_password)){
      $cstrong = True;
      $token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
      $query = 'SELECT id FROM users WHERE username=:username';
      $user_id = DB::query($query, $param)[0]['id'];
      $query = 'INSERT INTO login_tokens (`token`, `user_id`) VALUES (:token, :user_id)';
      $param = array(':token'=>sha1($token), ':user_id'=>$user_id);
      DB::query($query, $param);
      setcookie("SNID", $token, time() + 60 * 60 * 24 * 7, '/', NULL, NULL, TRUE);
      setcookie("SNID_", '1', time() + 60 * 60 * 24 * 3, '/', NULL, NULL, TRUE);
      if ($confirmed == "yes") {
        echo 'login_success';
        exit();
      }
      else {
        echo 'You need to confirm your account first, please check your emails';
        exit();
      }
    } 
    else {
      echo 'Incorrect password';
      exit();
    }
  } else {
    echo 'This user does not exists';
    exit();
  }
}
?>
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
    function logiin(){
      var u = document.getElementById('username').value
      var p = document.getElementById('password').value
      var status = document.getElementById("status")
      if(u == "" || p == "") {
        status.innerHTML = "Please fill out all of the form data";
      }
      else {
        var ajax = ajaxObj("POST", "login.php");
          ajax.onreadystatechange = function() {
          if(ajaxReturn(ajax) == true) {
            if(!ajax.responseText.includes('login_success')){
              status.innerHTML = ajax.responseText;
            } else {
              window.location.href = "http://localhost:8080/camagru/profile.php?u="+u+""
            }
            console.log(ajax.responseText);
          }
        }
        ajax.send("u="+u+"&p="+p);
      }
      if (document.getElementById('username')) {
        document.getElementById('username').value = ''
      }
      if (document.getElementById('password')) {
        document.getElementById('password').value = ''
      }
    }
  </script>
</head>

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
          <h1>Login to your account</h1>
          <form name="loginForm" id="loginForm" onsubmit="return false;">
          <input type="text" id="username" name="username" value="" placeholder="Username" onkeyup="restrict('username')" maxlength="16">
          <br><hr>
          <input id="password" type="password" name="password" placeholder="Password" maxlength="16">
          <br><hr>
          <input id="loginBtn" type="submit" name="login" onclick="logiin()" value="Login">
          </form>
          <a href="forgotPass.php">I forgot my password</a>
          </form>
        </div>
      </div>
    </div>
  </section>

<!-- ############################################################################################################ -->


<!-- ############################################################################################################ -->

<?php
  require_once 'footer.php';
?>

