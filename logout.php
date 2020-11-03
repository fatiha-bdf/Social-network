<?php 
include('./classes/DB.php');

if (isset($_POST['logout'])) {
  if (isset($_COOKIE['SNID'])) {
    $query = 'DELETE FROM login_tokens where token=:token';
    $param = array(':token'=>sha1($_COOKIE['SNID']));
    DB::query($query, $param);
  }
  setcookie('SNID', 1, time()-3600);
  setcookie('SNID_', 1, time()-3600);
  echo 'logged out';
}
?>