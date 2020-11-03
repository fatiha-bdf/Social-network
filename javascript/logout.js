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


function logout() {
  var logout = 'oui'
  var ajax = ajaxObj("POST", "logout.php");
  ajax.onreadystatechange = function() {
    if(ajaxReturn(ajax) == true) {
      if(ajax.responseText === 'logged out'){
        window.location.pathname =  '/camagru'
        console.log('done');
      }
    }
  }
  ajax.send("logout="+logout);
}