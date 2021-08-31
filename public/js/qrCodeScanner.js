const qrcodes = window.qrcode;

const video = document.createElement("video");
const canvasElement = document.getElementById("qr-canvas");
const canvas = canvasElement.getContext("2d");

const qrResult = document.getElementById("qr-result");
const outputData = document.getElementById("linkID"); 
//const burl = document.getElementById("linkID").setAttribute('href',yourLink);

const btnScanQR = document.getElementById("btn-scan-qr");

let scanning = false;

qrcode.callback = res => {
  if (res) {
    //outputData.innerText = res;
	//alert(res);
	//window.location.href = res;
	var arr = res.split("/").pop()
	//var URL = window.location.hostname+
	var URL = '/outlets?id='+arr; //alert(URL);
	window.location.href = URL;
	//document.getElementById("linkID").setAttribute('href',res);
    //scanning = false;
    // video.srcObject.getTracks().forEach(track => {
      // track.stop();
    // });
	//var result = outputData.innerHTML;
    qrResult.hidden = true;
    canvasElement.hidden = false;
    btnScanQR.hidden = true;
  }
};

btnScanQR.onclick = () => {
  navigator.mediaDevices
    .getUserMedia({ video: { facingMode: "environment" } })
    .then(function(stream) {
      scanning = true;
      qrResult.hidden = true;
      btnScanQR.hidden = true;
      canvasElement.hidden = false;
      video.setAttribute("playsinline", true); // required to tell iOS safari we don't want fullscreen
      video.srcObject = stream;
      video.play();
      tick();
      scan();
	  //window.location = res;
	  //redirect();
    });
};

function tick() {
  canvasElement.height = video.videoHeight;
  canvasElement.width = video.videoWidth;
  canvas.drawImage(video, 0, 0, canvasElement.width, canvasElement.height);

  scanning && requestAnimationFrame(tick);
}

function scan() {
  try {
    qrcode.decode(); 
  } catch (e) {
    setTimeout(scan, 300);
  }
}



