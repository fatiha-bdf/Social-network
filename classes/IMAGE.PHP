<?PHP
class Image {
  public static function saveimage($image_name, $dir, $user_id)
  {
    $query = 'INSERT into editor (`img_name`, `img_dir`, `date`, `user_id`) VALUES (:img_name, :img_dir, NOW(), :user_id)';
    $params = array(':img_name'=>$image_name, ':img_dir'=>$dir, ':user_id'=>$user_id);
    DB::query($query, $params);
    $newimage = DB::query('SELECT * FROM editor WHERE user_id=:user_id ORDER BY ID DESC LIMIT 1', array(':user_id'=>$user_id));
    // foreach ($newimage as $img) {
      echo "<img src='./img/editor/".$newimage[0]['img_name']."' id='finalimg'>"; // this has to be the ajax responsetext
    // }
  }

  public static function display_public_image() {
    $image = DB::query("SELECT * FROM gallery ORDER BY ID DESC", array());
    foreach ($image as $img) {
      $img = $img['img_name'];
      $likes = DB::query('SELECT likes FROM gallery WHERE img_name=:img_name', array(':img_name'=>$img))[0]['likes'];
      $numcomments = DB::query('SELECT COUNT(*) FROM `comments` where image=:image', array(':image'=>$img))[0][0] ;
      $user_id = DB::query('SELECT user_id FROM gallery WHERE img_name=:img_name', array(':img_name'=>$img))[0]['user_id'];
      $username = DB::query('SELECT username FROM users WHERE id=:user_id', array(':user_id'=>$user_id))[0]['username'];
      $date = DB::query('SELECT date FROM gallery WHERE img_name=:img_name', array(':img_name'=>$img))[0]['date']; 
      echo "<div id=".$img." class='whole'>
      <div class='imgandlikes'>
      <span>".$username."</span>
      <span>~</span>
      <span>".$date."</span>
      <img src='img/gallery/".$img."' class='image'/>
      <br>
      <img src='./img/iconLike.png' alt='' class='iconLike, likes' >
      <span class='numberlikes'>".$likes."</span>
      <img src='./img/iconComment.png' onclick='showComments(\"$img\"); return false' alt='' class='iconComment, likes'>
      <span class='numberComments'>".$numcomments."</span>
      <span class='showComments'> </span>
      </form>
      </div>
      </div>";
    }
  }

  public static function display_public_image_comment() {
    $image = DB::query("SELECT * FROM gallery ORDER BY ID DESC", array());
    foreach ($image as $img) {
      $img = $img['img_name'];
      $likes = DB::query('SELECT likes FROM gallery WHERE img_name=:img_name', array(':img_name'=>$img))[0]['likes'];
      $numcomments = DB::query('SELECT COUNT(*) FROM `comments` where image=:image', array(':image'=>$img))[0][0] ;
      $user_id = DB::query('SELECT user_id FROM gallery WHERE img_name=:img_name', array(':img_name'=>$img))[0]['user_id'];
      $username = DB::query('SELECT username FROM users WHERE id=:user_id', array(':user_id'=>$user_id))[0]['username'];
      $date = DB::query('SELECT date FROM gallery WHERE img_name=:img_name', array(':img_name'=>$img))[0]['date']; 

      echo "<div id=".$img." class='whole'>
      <div class='imgandlikes'>
      <span>".$username."</span>
      <span>~</span>
      <span>".$date."</span>
      <img src='img/gallery/".$img."' class='image'/>
      <br>
      <img src='./img/iconLike.png' onclick='like(\"$img\"); return false' alt='' class='iconLike, likes' >
      <span class='numberlikes'>".$likes."</span>
      <img src='./img/iconComment.png' onclick='showComments(\"$img\"); return false' alt='' class='iconComment, likes'>
      <span class='numberComments'>".$numcomments."</span>
      <div class='showComments'> </div>
      <form class='commentForm' onsubmit='return false'>
      <div>
      <textarea name='commentBody' class='commentBody' style='font-family:sans-serif;font-size:1.2em;background-color:#7FFFD4;'></textarea>
      </div>
      <input id='commentBtn'  onclick='comment(\"$img\")' type='submit' value='Comment'>
      </form>
      </div>
      </div>";
    }
  }

  public static function displayuserimage($user_id) 
  {
    $image = DB::query('SELECT * FROM editor WHERE user_id=:user_id ORDER BY ID DESC', array(':user_id'=>$user_id));
    echo "";
    foreach ($image as $img) {
      $img = $img['img_name'];
      echo "<div id=".$img.">
      <div class='imgandicons'>
      <img src='./img/editor/".$img."'class='imageinlist'/>
      <img src='./img/iconDelete.png' onclick='deletePhoto(\"$img\"); return false' alt='' id='iconDelete' class='icon'>
      <img src='./img/iconAdd.jpeg' onclick='movetoGallery(\"$img\"); return false' alt='' id='iconAdd' class='icon'>
      </div>
      </div>";
    }
  }

  public static function movetogallery($img_name, $dir, $user_id)
  {
    // delete from editor table on db
    $query = 'DELETE FROM editor WHERE img_name=:img_name';
    $params = array(':img_name'=>$img_name);
    DB::query($query, $params);
    $query = 'INSERT into gallery (`img_name`, `img_dir`, `date`, `user_id`, `likes`) VALUES (:img_name, :img_dir, NOW(), :user_id, 0)';
    $params = array(':img_name'=>$img_name, ':img_dir'=>$dir, ':user_id'=>$user_id);
    DB::query($query, $params);
    
    //move photo from editor directory to gallery 
    $old_dir = 'file:///Users/fboudyaf/Desktop/mamp/apache2/htdocs/camagru/img/editor/';
    $old_filename = $old_dir.$img_name;
    $new_filename = $dir.$img_name;
    rename($old_filename, $new_filename);
    echo "moved";
  }

  public static function displaygallery($user_id) {
    $image = DB::query('SELECT * FROM gallery WHERE user_id=:user_id ORDER BY ID DESC', array(':user_id'=>$user_id));
    foreach ($image as $img) { // add date also
      $img = $img['img_name'];
      $likes = DB::query('SELECT likes FROM gallery WHERE img_name=:img_name', array(':img_name'=>$img))[0]['likes'];
      $numcomments = DB::query('SELECT COUNT(*) FROM `comments` where image=:image', array(':image'=>$img))[0][0] ;
      echo "<div id=".$img." class='whole'>
      <div class='imgandlikes'>
      <img src='img/gallery/".$img."' class='image'/>
      <br>
      <img src='./img/iconLike.png' onclick='like(\"$img\"); return false' alt='' class='iconLike, likes' >
      <span class='numberlikes'>".$likes."</span>
      <img src='./img/iconComment.png' onclick='showComments(\"$img\"); return false' alt='' class='iconComment, likes'>
      <span class='numberComments'>".$numcomments."</span>
      <img src='./img/iconDelete.png' onclick='deletePhoto(\"$img\"); return false' alt='' id='iconDelete' class='icon'>
      <div class='showComments'> </div>
      <form class='commentForm' onsubmit='return false'>
      <div>
      <textarea name='commentBody' class='commentBody' style='font-family:sans-serif;font-size:1.2em;background-color:#7FFFD4;'></textarea>
      </div>
      <input id='commentBtn'  onclick='comment(\"$img\")' type='submit' value='Comment'>
      </form>
      </div>
      </div>";
    }
  }
  
  public static function comment($image, $body, $username, $user_id) {
    $query = 'INSERT into comments (`image`, `body`, `date`, `username`, `user_id`) VALUES (:image, :body, NOW(), :username, :user)' ;
    $params = array(':image'=>$image, ':body'=>$body, ':username'=>$username, ':user'=>$user_id);
    DB::query($query, $params);
  }

  public static function showComments($image) {
    $comments = DB::query('SELECT * FROM comments WHERE image=:image ORDER BY ID DESC', array(':image'=>$image));
    echo "<ul class='listcomments'";
    foreach ($comments as $cmt) { // add date also
      $body = $cmt['body'];
      $date = $cmt['date'];
      $username = $cmt['username'];
      echo "<div id=".$image.">
      <li><p>".$body." ~ ".$username."</p></li>
      </div>";
    }
    echo "</ul>";
  }

  public static function like($photo, $user) {
    if (!DB::query('SELECT user_id FROM user_likes WHERE img_name=:img_name and user_id=:user_id', array(':img_name'=>$photo, ':user_id'=>$user))) {
      DB::query('UPDATE gallery SET likes=likes+1 where img_name=:img_name', array(':img_name'=>$photo));
      DB::query('INSERT into user_likes (`img_name`, `user_id`) values (:img_name, :user_id)', array(':img_name'=>$photo, ':user_id'=>$user));
      echo 'liked';
    }
    else {
      DB::query('UPDATE gallery SET likes=likes-1 where img_name=:img_name', array(':img_name'=>$photo));
      DB::query('DELETE FROM user_likes where img_name=:img_name and user_id=:user_id', array(':img_name'=>$photo, ':user_id'=>$user));
      echo 'unliked';
    }
  }

  public static function deleteimage($img_name) {
    $query = 'DELETE FROM editor WHERE img_name=:img_name';
    $params = array(':img_name'=>$img_name);
    DB::query($query, $params);
    $query = 'DELETE FROM gallery WHERE img_name=:img_name';
    $params = array(':img_name'=>$img_name);
    DB::query($query, $params);
    $file = 'file:///Users/fboudyaf/Desktop/mamp/apache2/htdocs/camagru/img/editor/'.$img_name;
    if (file_exists($file)) {
      unlink($file);
    }
    $file = 'file:///Users/fboudyaf/Desktop/mamp/apache2/htdocs/camagru/img/gallery/'.$img_name;
    if (file_exists($file)) {
      unlink($file);
    }
    echo "deleted";
  }
}
?>