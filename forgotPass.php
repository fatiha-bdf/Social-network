<?php
include('classes/DB.php');
include('classes/LOGIN.php');

function randomPassword($length,$count, $characters) {

  $symbols = array();
  $passwords = array();
  $used_symbols = '';
  $pass = '';

  $symbols["lower_case"] = 'abcdefghijklmnopqrstuvwxyz';
  $symbols["upper_case"] = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $symbols["numbers"] = '1234567890';
  $symbols["special_symbols"] = '!?~@#-_+<>[]{}';

  $characters = split(",",$characters); // get characters types to be used for the passsword
  foreach ($characters as $key=>$value) {
      $used_symbols .= $symbols[$value]; // build a string with all characters
  }
  $symbols_length = strlen($used_symbols) - 1; //strlen starts from 0 so to get number of characters deduct 1
    
  for ($p = 0; $p < $count; $p++) {
      $pass = '';
      for ($i = 0; $i < $length; $i++) {
          $n = rand(0, $symbols_length); // get a random character from the string with all characters
          $pass .= $used_symbols[$n]; // add the character to the password string
      }
      $passwords[] = $pass;
  }
    
  return $passwords; // return the generated password
}


if (isset($_POST['e'])) {
  $email = $_POST['e'];
  $response = array();
  if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $query = 'SELECT email FROM users WHERE email=:email';
    $params = array(':email'=>$email);
    if (DB::query($query, $params)[0]['email']) {
      $query = 'SELECT id FROM users WHERE email=:email';
      $userid = DB::query($query, $params)[0]['id'];
      $newPass = randomPassword(10,1,"lower_case,upper_case,numbers,special_symbols");
      $query = 'UPDATE users set password=:newpass where id=:userid';
      $param = array(':newpass'=>password_hash($newPass[0], PASSWORD_BCRYPT), ':userid'=>$userid);
      DB::query($query, $param);
      // $cstrong = TRUE;
      // $token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
      // $query = 'INSERT INTO pass_tokens VALUES (\'\', :token, :user_id)';
      // $params = array(':token'=>sha1($token), ':user_id'=>$id);
      // DB::query($query, $params);
      
      $from = 'fatiha@camagru.com';
      $subject = "New password password";
      $headers = "Content-type: text/html; charset=utf-8\r\n";
      $message = '<!DOCTYPE html>
                <html>
                <head>
                <meta charset="UTF-8">
                <title>Camagru</title>
                </head>
                <body style="margin:0px; font-family:Tahoma, Geneva, sans-serif;">
                <div style="padding:10px; background:#333; font-size:24px; color:#CCC;">
                <a href="http://localhost:8080/camagru/"></a>
                Camagru password reset
                </div>
                <div style="padding:24px; font-size:17px;">Hello,<br /><br />
                Click the link below to login when ready:<br /><br />
                <a href="http://localhost:8080/camagru/login.php">
                Click here</a><br /><br />
                You can now login using your new password:<br />
                * E-mail Address: <b>'.$email.'</b>
                * Password: <b>'.$newPass[0].'</b>
                </div>
                </body>
                </html>';
      $headers = "From: $from\n";
      $headers .= "MIME-Version: 1.0\n";
      $headers .= "Content-type: text/html; charset=iso-8859-1\n";
      if (mail('fatiha.boudyaf@gmail.com', $subject, $message, $headers)){
      echo 'email sent';
      exit();
      } else {
        echo 'problem sending email';
        exit();
      }
    }
    else {
      echo 'This Email not registered';
      exit();
    }
  } 
  else {
    echo 'invalid email';
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
    function forgotPasss(){
      var e = document.getElementById('email').value
      var status = document.getElementById("status")
      if(e == ""){
        status.innerHTML = "Please enter your email";
      }
      else {
        var ajax = ajaxObj("POST", "forgotPass.php");
          ajax.onreadystatechange = function() {
          if(ajaxReturn(ajax) == true) {
            if(ajax.responseText.includes('email sent')){
              document.querySelector('.showcase-contentlog').innerHTML = 'An email was just sent to '+e+', check your inbox!'
              var JSONStr = ajax.responseText
              var JSONObj = JSON.parse(JSONStr)
              var token = JSONObj['token']
              console.log(token);
            }
            else {
              status.innerHTML = ajax.responseText;
            }
          }
        }
        ajax.send("e="+e);
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
          <h1>Please enter your email address to reset your password</h1>
          <form name="forgotPass" id="forgotPass" onsubmit="return false;">
          <input type="text" id="email" name="email" value="" placeholder="email" onkeyup="restrict('email')" maxlength="88">
          <br><hr>
          <input id="forgotBtn" type="submit" name=forgotBtn" onclick="forgotPasss()" value="Send Email">
          </form>
        </div>
      </div>
    </div>
  </section>

<!-- ############################################################################################################ -->

  <section id="company">
    <div class="container">
      <div class="row center-xs center-sm center-md center-lg">
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
          <h4>contact Us</h4>
          <ul>
            <li><i class="fa fa-phone"></i> +33 649 636 775</li>
            <li><i class="fa fa-envelope"></i> fatiha.boudyaf@gmail.com</li>
          </ul>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
          <h4>About Us</h4>
          <p>lksjdaldjasldjldjasldjasldja aslkdj asldjasld lasdj</p>
        </div>
      </div>
    </div>
  </section>

<!-- ############################################################################################################ -->

  <footer id="main-footer">
    <div class="container">
      <div class="row center-xs center-sm center-md center-lg">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          <p>Copyright &copy; 2019 | fboudyaf</p>
        </div>
      </div>
    </div>
  </footer>



