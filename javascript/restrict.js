
function restrict(elem) {  //onkeyup = quand on appui sur une ouche et relache
  var tf = document.getElementById(elem)
  var rx = new RegExp;
  if(elem == "email") {
    rx = /[' "]/gi;
  }
  else if (elem == "username") {
    rx = /[^a-z0-9]/gi;
  }
  tf.value = tf.value.replace(rx, "");
}
