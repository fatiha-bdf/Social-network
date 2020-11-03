<?php
include_once('./classes/DB.php');
include_once('./classes/LOGIN.php');

if (LOGIN::isLogged()) {
  $user_id = LOGIN::isLogged();
}
else {
  header("location:/camagru/login.php");
}

if(isset($_POST['check'])){
  $check = $_POST['check'];
  if ($check == 'true') {
    DB::query("UPDATE users SET allow_notif='yes' where id=:user_id", array(':user_id'=>$user_id));
  }
  else {
    DB::query("UPDATE users SET allow_notif='no' where id=:user_id", array(':user_id'=>$user_id));
  }
  exit();
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
  <script src="javascript/ajax.js"></script>
  <style>
    li{
      list-style: none;
    }

    ul li {
      padding-right: 20px;
      list-style
    }

    li a {
      text-decoration: none;
      color: #888;
      font-family: "Times New Roman", Times, serif;
      padding : 20px;
    }

    li h1 {
      text-decoration: none;
      color: #888;
      font-family: "Times New Roman", Times, serif;
      padding : 20px;
    }
  </style>

<script>
function check() {
  var x = document.getElementById("myCheck").checked;
  var ajax = ajaxObj("POST", "userSettings.php");
  ajax.send("check="+x);
  console.log(x);
}
</script>
</head>


<!-- ############################################################################################################ -->

<body>
<header id="main-header">
    <div class="container">
      <div class="row end-sm end-md end-lg center-xs middle-xs middle-sm middle-md middle-lg">
        <div class="col-xs-10 col-sm-2 col-md-2 col-lg-2">
          <a href="http://localhost:8080/camagru/"><img src="img/logo.png"></a>
        </div>
        <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10">
        <nav id="navbar">
          <ul>
            <li><a href="profile.php">Back to my profile</a></li>
            <li><img src='img/iconLogout.png' alt='' onclick='logout()' id='logoutBtn' class='icon'></li>
          </ul>
        </nav>
        </div>
      </div>
    </div>
  </header>
  <script src="javascript/logout.js"></script>
</body>

<!-- ############################################################################################################ -->

<section id="showcaselog">
    <div class="containerlog">
      <div class="row center-xs center-sm center-md center-lg middle-xs middle-sm middle-md middle-lg">
        <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9 showcase-contentlog">
        <ul class="listeSettings">
          <li><h1><a href="changePass.php">Change password</a></h1></li>
          <li><h1><a href="changeEmail.php">Change email</a></h1></li>
          <li><h1><a href="changeUsername.php">Change username</a></h1></li>
          <li><h1>Receive notifiations by email:</h1><input type="checkbox" id="myCheck" name="scales"
          <?php  $allow_notif = DB::query("SELECT allow_notif FROM users where id=:user_id", array(':user_id'=>$user_id))[0]['allow_notif']; 
          if($allow_notif == 'yes') {
            echo 'checked';
          }
          ?>
        
         
          ><button onclick="check()">Confirm</button>
        </ul>
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
