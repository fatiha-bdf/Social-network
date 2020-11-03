function ajaxObj( meth, url ) {
	var x = new XMLHttpRequest();
	x.open( meth, url, true );
	x.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	return x;
}

function ajaxReturn(x){
	if(x.readyState == 4 && x.status == 200){
	    return true;
	}
}

function like(liked) {
  var imgId = document.getElementById(liked);
  var likeInside = imgId.getElementsByClassName('numberlikes')[0]
  var iconInside = imgId.getElementsByClassName('iconLike, likes')[0]
  var ajax = ajaxObj("POST", "like.php");
  ajax.onreadystatechange = function() {
    if(ajaxReturn(ajax) == true) {
      numLikes = likeInside.innerHTML;
      if(ajax.responseText === 'liked'){
        newNumLikes = parseInt(numLikes, 10) + 1;
        likeInside.innerHTML = newNumLikes;
        iconInside.style.backgroundColor = '#7FFFD4'
      } 
      else if (ajax.responseText.includes('unliked')){
        newNumLikes = parseInt(numLikes, 10) - 1;
        likeInside.innerHTML = newNumLikes;
        iconInside.style.backgroundColor = 'initial'
      }
    }
  }
  ajax.send("liked="+liked);
}

function comment(photo) {
  var imgId = document.getElementById(photo);
  var commentInside = imgId.getElementsByClassName('numberComments')[0]
  var body = imgId.getElementsByClassName('commentBody')[0].value
  var ajax = ajaxObj("POST", "comment.php");
  ajax.onreadystatechange = function() {
    if(ajaxReturn(ajax) == true) {
      numComments = commentInside.innerHTML;
      if(ajax.responseText === 'commented'){
        imgId.getElementsByClassName('commentBody')[0].value = "";
        newNumComments = parseInt(numComments, 10) + 1;
        commentInside.innerHTML = newNumComments;
      }
    }
  }
  ajax.send("photo="+photo+"&body="+body);
}

var clicked = true;
function showComments(photo) {
  var imgId = document.getElementById(photo);
  var commentInside = imgId.getElementsByClassName('numberComments')[0]
  if (commentInside.innerHTML === '0') {
    return;
  }
  if(clicked) {
    var ajax = ajaxObj("POST", "showComments.php");
    var imgId = document.getElementById(photo);
    ajax.onreadystatechange = function() {
      if(ajaxReturn(ajax) == true) {
        if(ajax.responseText.includes(photo)) {
          imgId.getElementsByClassName('showComments')[0].innerHTML = ajax.responseText
          if (imgId.getElementsByClassName('commentForm')[0]) {
            imgId.getElementsByClassName('commentForm')[0].style.display = 'none'
          }
        }
      }
    }
    ajax.send("photo="+photo);
    clicked = !clicked;
  }
  else {
    var imgId = document.getElementById(photo);
    imgId.getElementsByClassName('showComments')[0].innerHTML = ''
    if (imgId.getElementsByClassName('commentForm')[0]) {
      imgId.getElementsByClassName('commentForm')[0].style.display = 'initial'
    }
    clicked = !clicked;
  }
}


function backtoWebcam() {
  window.location.pathname = "/camagru/webcam.php"
}

function deletePhoto(photo) {
  var imgId = document.getElementById(photo);
  var ajax = ajaxObj("POST", "deletePhoto.php");
  ajax.onreadystatechange = function() {
    if(ajaxReturn(ajax) == true) {
      if(ajax.responseText.includes('deleted')){
        imgId.innerHTML = "";
        setTimeout(function(){ 
          imgId.innerHTML = "";
        }, 2000);
      }
    }
  }
  ajax.send("todelete="+photo);
}
