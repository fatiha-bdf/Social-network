<?php
class LOGIN {
  public static function isLogged() {
    if (isset($_COOKIE['SNID'])) {
      $query = 'SELECT user_id FROM login_tokens WHERE token=:token';
      $param = array(':token'=>sha1($_COOKIE['SNID']));
      if (DB::query($query, $param)){
        $user_id = DB::query($query, $param)[0]['user_id'];
        if (isset($_COOKIE['SNID_'])) {
          return $user_id;
        } 
        else {
          $cstrong = True;
          $token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
          
          $query = 'INSERT INTO login_tokens (`token`, `user_id`) VALUES (:token, :user_id)';
          $param = array(':token'=>sha1($token), ':user_id'=>$user_id);
          DB::query($query, $param);
          
          $query = 'DELETE FROM login_tokens WHERE token=:token';
          $param = array(':token'=>sha1($_COOKIE['SNID']));
          DB::query($query, $param);

          setcookie("SNID", $token, time() + 60 * 60 * 24 * 7, '/', NULL, NULL, TRUE);
          setcookie("SNID_", '1', time() + 60 * 60 * 24 * 3, '/', NULL, NULL, TRUE);

          return $userid;
        }
      }
    }
    return false;
  }
}