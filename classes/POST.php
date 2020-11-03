<?php
class POST {
  public static function createpost($postbody, $loggeduser, $user) {
    $logged_username = DB::query('SELECT username FROM users WHERE id=:loggeduser', array(':loggeduser'=>$loggeduser))[0]['username'];
    if($user == $loggeduser)
    {
      if (strlen($postbody) < 1) {
        echo 'Empty field, try again';
        // header("location:/camagru/profile.php?username=$logged_username");
      }
      if (strlen($postbody) > 160) {
        echo 'Posts must not exceed 160 characters';
        // header("location:/camagru/profile.php?username=$logged_username");
      }
      $query = 'INSERT into comments VALUES (\'\', :postbody, NOW(), :loggeduser, 0)';
      $params = array(':postbody'=>$postbody, ':loggeduser'=>$loggeduser);
      DB::query($query, $params);
    } 
    else {
      die('Wrong user, this is not your profile ... you are not Allowed to post anything here');
    }
  }
   
  
  public static function displaypost($user, $username) {
    $dbposts = DB::query('SELECT * FROM comments WHERE user_id=:user ORDER BY id DESC', array(':user'=>$user));
    foreach($dbposts as $p) {
      if (!DB::query('SELECT post_id FROM post_likes WHERE post_id=:postid and user_id=:userid', array(':postid'=>$p['id'], ':userid'=>$user))) {
        $posts .= htmlspecialchars($p['body'])."
        <form action='profile.php?username=$username&postid=".$p['id']."'method='post'>
        <input type='submit' name='like' value='Like'>
        <span>".$p['likes']." likes</span>
        </form>
        <hr/></br/>";
      }
      else { 
        $posts .= htmlspecialchars($p['body'])."
        <form action='profile.php?username=$username&postid=".$p['id']."'method='post'>
        <input type='submit' name='unlike' value='Unlike'>
        <span>".$p['likes']." likes</span>
        </form>
        <hr/></br/>";
      }
    }
    return $posts;
  }
}
?>