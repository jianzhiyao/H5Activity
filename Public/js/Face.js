function Face() {
	status = 0;
	msg = "";
	obj = null;
	video = null;
	canvas = null;
	function playVideo($videoId) {
		video = document.getElementById($videoId),
		videoObj = {
			"video": true
		},
		errBack = function(error) {
			console.log("Video capture error: ", error.code);
		};
		//navigator.getUserMedia这个写法在Opera中好像是navigator.getUserMedianow       
		if (navigator.getUserMedia) {
			navigator.getUserMedia(videoObj,
			function(stream) {
				video.src = stream;
				video.play();
			},
			errBack);
		} else if (navigator.webkitGetUserMedia) {
			navigator.webkitGetUserMedia(videoObj,
			function(stream) {
				if (typeof(window.webkitURL) != "undefined") video.src = window.webkitURL.createObjectURL(stream);
				else video.src = window.URL.createObjectURL(stream);
				video.play();
			},
			errBack);
		}
	}
	function setDataFromVideoToCanvas($canvasId) {
		canvas = document.getElementById($canvasId);
		var context = canvas.getContext("2d");
		context.drawImage(video, 0, 0, canvas.width, canvas.height);
		var imgdata = context.getImageData(0, 0, canvas.width, canvas.height);
		var data = imgdata.data;
		var delta = -60;
		for (var i = 0,
		n = data.length; i < n; i += 4) {
			//var average=(data[i]+data[i+1]+data[i+2])/3;0.393
			var average = 0.393 * data[i] + 0.769 * data[i + 1] + 0.189 * data[i + 2] + 0;
			data[i] = average;
			data[i + 1] = average;
			data[i + 2] = average;

			//lightness
			data[i] += delta; // red
			data[i + 1] += delta; // green
			data[i + 2] += delta; // blue
		}
		context.putImageData(imgdata, 0, 0);
		return canvas;
	}
	function postCanvasData($canvasId, $URL, succCB, failCB) {
		var imgData = setDataFromVideoToCanvas($canvasId).toDataURL();
		$.post($URL, {
			"img": imgData
		},
		function(data, status) {
			if (status == "success") {
				succCB(data);
			} else {
				failCB();
			}
		},
		"text");
	}

	return {
		playVideo: playVideo,
		postCanvasData: postCanvasData
	};
}