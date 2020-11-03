<?php
class LIKE {
  public static function likepost($user, $postid){
    if (!DB::query('SELECT user_id FROM post_likes WHERE post_id=:postid and user_id=:userid', array(':postid'=>$postid, ':userid'=>$user))) {
      DB::query('UPDATE posts SET likes=likes+1 where id=:postid', array(':postid'=>$postid));
      DB::query('INSERT into post_likes values (:postid, :userid)', array(':postid'=>$postid, ':userid'=>$user));
      echo 'you just liked this';
    }
    else {
      DB::query('UPDATE posts SET likes=likes-1 where id=:postid', array(':postid'=>$postid));
      DB::query('DELETE FROM post_likes where post_id=:postid and user_id=:userid', array(':postid'=>$postid, ':userid'=>$user));
      echo 'you just unliked this';
    }
  }
}
?> 