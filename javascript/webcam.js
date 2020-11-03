var video = document.getElementById('videoElmt')
var videoObj = document.querySelector('.videoObj')
var snapCanvas = document.getElementById('snapCanvas')
var snapContext = snapCanvas.getContext('2d')
var snap = document.getElementById("snap")
var resizedCanvas = document.getElementById("resizedCanvas");
var resizedContext = resizedCanvas.getContext("2d");
var capture = document.getElementById('capture')
var captureNew = document.getElementById('captureNew')
var clickFilterInstruction = document.getElementById('clickFilterInstruction')
var display = document.getElementById('display')
var filters = document.getElementById('filters')
var filter = 'nofilter' // de base pas de filtre
var todelete // if user doesn't press 'save picture' then the montage has to be deleted (it had to be created in order to be displayed to the user)
var snapsrc
var addedPhoto

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

saveBtn.style.display = "none"
captureNew.style.display = "none"
filters.style.display = "none"
snapCanvas.style.display = "none"
clickFilterInstruction.style.display = "none"

// ######## filters ########
var glasses = document.getElementById('glasses')
var cat = document.getElementById('cat')
var mustache = document.getElementById('mustache')
var rainbow = document.getElementById('rainbow')
var cadre = document.getElementById('cadre')
var cadre2 = document.getElementById('cadre2')
var banane = document.getElementById('banane')

if(navigator.mediaDevices.getUserMedia) {
  navigator.mediaDevices.getUserMedia({
    video: true,
  }).then(function(stream) {
    video.srcObject = stream
    video.play()
  }).catch(function(error) {
    console.log(error);
  })
}

document.getElementById('capture').addEventListener('click', takePhoto)

function takePhoto() {
  clickFilterInstruction.style.display = "Block"
  captureNew.style.display = "block"
  filters.style.display = 'initial'
  saveBtn.style.display = "block"
  fileSelect.style.display = "none";
  snap.style.display = "none"
  videoObj.style.display = "none"
  capture.style.display = 'none'
  resizedCanvas.style.display= "none";
  if (snapCanvas.getContext) {
    snapCanvas.style.display = "block"
    snapCanvas.style.margin = "0 auto"
    snapContext.drawImage(video, 0, 0, snapCanvas.width, snapCanvas.height)
    resizedCanvas.height = "500";
    resizedCanvas.width = "650";
    resizedContext.drawImage(snapCanvas, 0, 0, resizedCanvas.width, resizedCanvas.height);
    var myResizedData = resizedCanvas.toDataURL();
    snap.src = myResizedData;
    cat.addEventListener('click', function() {
      filter = "img/filter/cat-bounce.png"
      send()
    })
    glasses.addEventListener('click', function() {
      filter = "img/filter/glasses.png"
      send()
    })
    mustache.addEventListener('click', function() {
      filter = "img/filter/mustache.png"
      send()
    })
    rainbow.addEventListener('click', function() {
      filter = "img/filter/rainbow.png"
      send()
    })
    cadre.addEventListener('click', function() {
      filter = "img/filter/cadre.png"
      send()
    })
    cadre2.addEventListener('click', function() {
      filter = "img/filter/cadre2.png"
      send()
    })
    banane.addEventListener('click', function() {
      filter = "img/filter/banane.gif"
      send()
    })
    saveBtn.addEventListener('click', function() {
      if (filter == 'nofilter') { 
        send();
      }
      reload(); // reloader me permet de voir l'image afficher sur la liste
    })
    captureNew.addEventListener('click', function() {
      if (filter != 'nofilter') { //if i added a filter, means the photo is already saved automatically so have to delete it
        // getting the name of the image to delete (function send returns the url of the photo in <div>id=display)
        var todelete = document.querySelector("#display img").src;
        todelete = todelete.split("/")
        var count = todelete.length
        todelete = todelete[count-1]
        deletelastPhoto(todelete);
      }
      else {
        reload () // if i just took a picture alone, means picture in not saved yet so no need to delete
      }
    });
  }
}


function handleFiles()
{
  // snapsrc = ''; // if we click to choose file ..means we didn't take a photo with camera
  // snap.style.display = 'none';
  filters.style.display = 'initial'
  filter = 'nofilter';
  var f = document.getElementById('fileSelect').files[0];
  var extensions_ok		= 'png'; // n'autoriser que les png
  var file_name	= f.name.toLowerCase(); // nom du fichier
  if(file_name!='') {
    var file_array 		= file_name.split('.');
    var file_extension	= file_array[file_array.length-1]; // extension du fichier (dernier élément)
    if(extensions_ok.indexOf(file_extension)===-1) {
      alert('Type de fichier incorrect');
    }
    else {
      var file    = document.querySelector('input[type=file]').files[0];
      var reader  = new FileReader();
      reader.addEventListener("load", function () {
        snap.src = reader.result;
        // send(snap.src);
      }, false);
      if (file) {
        reader.readAsDataURL(file);
      }
    }
    cat.addEventListener('click', function() {
      filter = "img/filter/cat-bounce.png"
      send()
    })
    glasses.addEventListener('click', function() {
      filter = "img/filter/glasses.png"
      send()
    })
    mustache.addEventListener('click', function() {
      filter = "img/filter/mustache.png"
      send()
    })
    rainbow.addEventListener('click', function() {
      filter = "img/filter/rainbow.png"
      send()
    })
    cadre.addEventListener('click', function() {
      filter = "img/filter/cadre.png"
      send()
    })
    cadre2.addEventListener('click', function() {
      filter = "img/filter/cadre2.png"
      send()
    })
    banane.addEventListener('click', function() {
      filter = "img/filter/banane.gif"
      send()
    })
    saveBtn.addEventListener('click', function() {
      if (filter == 'nofilter') { 
        send();
      }
      reload(); // reloader me permet de voir l'image afficher sur la liste
    })
    captureNew.addEventListener('click', function() {
      if (filter != 'nofilter') { //if i added a filter, means the photo is already saved automatically so have to delete it
        // getting the name of the image to delete (function send returns the url of the photo in <div>id=display)
        var todelete = document.querySelector("#display img").src;
        todelete = todelete.split("/")
        var count = todelete.length
        todelete = todelete[count-1]
        deletelastPhoto(todelete);
      }
      else {
        reload () // if i just took a picture alone, means picture in not saved yet so no need to delete
      }
    })
  }
  videoObj.style.display = "none"
  capture.style.display = "none"
  saveBtn.style.display = "block"
  captureNew.style.display = "block"
  clickFilterInstruction.style.display = "Block"
}



function send() {   // only used if i take webcam picture
  var ajax = ajaxObj("POST", "webcam.php");
  ajax.onreadystatechange = function() {
    if(ajaxReturn(ajax) == true) {
      if(ajax.responseText.includes('<img src=')){
        display.innerHTML = ajax.responseText;
        window.scrollTo(0, 0);
        snapCanvas.style.display = 'none';
        snap.style.display = 'none';
        clickFilterInstruction.style.display = 'none';
      }
      else {
        var error = document.getElementById('error')
        error.innerHTML = 'An error occured, please try again'
      }
    }
  }
  ajax.send("snap="+snap.src+"&filter="+filter);
}

// ################# MOVE FINAL IMAGE TO GALLERY #############


function movetoGallery(x) {
  var blockofimage = document.getElementById(x)
  var ajax = ajaxObj("POST", "movetogallery.php");
  ajax.onreadystatechange = function() {
    if(ajaxReturn(ajax) == true) {
      if(ajax.responseText.includes('moved')){
        blockofimage.innerHTML = "Photo moved to gallery";
        setTimeout(function(){ 
          blockofimage.innerHTML = "";
        }, 2000);
      }
      else {
        var error = document.getElementById('error')
        error.innerHTML = 'An error occured, please try again'
      }
    }
  }
  ajax.send("tomove="+x);
} 

function deletePhoto(x) {
  var blockofimage = document.getElementById(x)
  var ajax = ajaxObj("POST", "deletePhoto.php");
  ajax.onreadystatechange = function() {
    if(ajaxReturn(ajax) == true) {
      if(ajax.responseText.includes('deleted')){
        blockofimage.innerHTML = "Photo deleted";
        setTimeout(function(){ 
          blockofimage.innerHTML = "";
        }, 2000);
      }
      else {
        var error = document.getElementById('error')
        error.innerHTML = 'An error occured, please try again'
      }
    }
  }
  ajax.send("todelete="+x);
}

function deletelastPhoto(todelete) {
  var ajax = ajaxObj("POST", "deletePhoto.php");
  ajax.onreadystatechange = function() {
    if(ajaxReturn(ajax) == true) {
      if(ajax.responseText.includes('deleted')){
        reload();
      }
    }
  }
  ajax.send("todelete="+todelete);
}

function gotoGallery() {
  window.location.pathname = '/camagru/profile.php'
}

function reload() {  // if i click on retake picture
  window.location.pathname = '/camagru/webcam.php'
}

