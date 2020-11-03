function ajax(meth, url, toSend) {
  const xhr = new XMLHttpRequest();

  xhr.open(meth, url, true);

  console.log('READYSTATE', xhr.readyState); // ###########  checking status (for me)

  xhr.onload = function(){
    if(this.status === 200) {
      console.log('READYSTATE', xhr.readyState); 
    }
  }
  xhr.onerror = function() {
    console.log('Request error...');
  }
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send(toSend);
  console.log(xhr);
  console.log(toSend);
  return xhr;
}

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

