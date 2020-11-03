<?php
include_once('./classes/DB.php');
include_once('./classes/LOGIN.php');
include_once('./classes/IMAGE.php');

if (LOGIN::isLogged()) {
  $user_id = LOGIN::isLogged();
  $username = DB::query('SELECT username FROM users WHERE id=:user_id', array(':user_id'=>$user_id))[0]['username'];
}
else {
  header("location:/camagru/login.php");
}


if (isset($_POST['photo']) && (isset($_POST['body']))) {
  $photo = htmlspecialchars($_POST['photo']);
  $body = htmlspecialchars($_POST['body']);
  if(empty($body)) {
    exit();
  }
  IMAGE::comment($photo, $body, $username, $user_id);
  // send mail
  $photo_owner_id = DB::query('SELECT user_id FROM gallery WHERE img_name=:photo', array(':photo'=>$photo))[0]['user_id'];
  $photo_owner_username = DB::query('SELECT username FROM users WHERE id=:photo_owner_id', array(':photo_owner_id'=>$photo_owner_id))[0]['username'];
  $from = 'fatiha@camagru.com';
  $subject = "Someone commented your picture";
  $headers .= "Content-type: text/html; charset=utf-8\r\n";
  $message = '<!DOCTYPE html>
            <html>
            <head>
            <meta charset="UTF-8">
            <title>Camagru</title>
            </head>
            <body style="margin:0px; font-family:Tahoma, Geneva, sans-serif;">
            <div style="padding:10px; background:#333; font-size:24px; color:#CCC;">
            New notification ! Check your profile !
            </div>
            <div style="padding:24px; font-size:17px;">Hello '.$photo_owner_username.',<br /><br />
            Someone just commented on your photo, Check it out !<br /><br />
            </div>
            </body>
            </html>';
  $headers = "From: $from\n";
  $headers .= "MIME-Version: 1.0\n";
  $headers .= "Content-type: text/html; charset=iso-8859-1\n";
  $allow_notif = DB::query("SELECT allow_notif FROM users where id=:user_id", array(':user_id'=>$user_id))[0]['allow_notif'];
  if ($allow_notif == 'yes') {
    if (mail('fatiha.boudyaf@gmail.com', $subject, $message, $headers)){
      echo 'commented';
    } else {
      echo 'problem sending email';
    }
    exit();
  }
  echo 'commented';
  exit();
} else {
  echo 'Error: please try again';
}
?>