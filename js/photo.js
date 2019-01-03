var video = document.getElementById('video');
if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia)
{
    navigator.mediaDevices.getUserMedia({ video: true}).then(function(stream)
    {
        video.srcObject = stream;
    });
}

var tmpImg = document.getElementById('tmpImg');
var file;
var reader;
function encodeImageFileAsURL(element) {
	file = element.files[0];
	reader = new FileReader();
	reader.onloadend = function() {
        tmpImg.style.visibility = "visible";
		video.style.visibility = "hidden";
		var upload = reader.result;
		tmpImg.src = reader.result;
		tmpImg.id = "tmpImg";
	}
	reader.readAsDataURL(file);
}


function snap()
{
    var cont = document.getElementById('im').getContext('2d');
    var can = document.getElementById('filters');
    var up = document.getElementById('upload');
    if (video.style.visibility == "hidden") {
        cont.drawImage(tmpImg, 0, 0,400,300);
    } else {
        cont.drawImage(video, 0, 0,400,300);
    }
    cont.drawImage(tmpImg, 0, 0,400,300);
    cont.drawImage(up,0,0,400,300);
    cont.drawImage(can,0,0,400,300);
    var str = document.getElementById('im').toDataURL();
    document.getElementById("img").value = str;
}

var filters = new Array();
filters[0] = "../html/pika.png";
filters[1] = "../html/pik.png";
filters[2] = "../html/poop.png";

function add_filter(e)
{
    var img = new Image;
    img.crossOrigin = "Anonymous";
    img.src = filters[e];
    var can = document.getElementById('filters').getContext('2d');
    can.drawImage(img,150,100,70,70);
}