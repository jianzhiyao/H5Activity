<?php if (!defined('THINK_PATH')) exit();?><script src="Public\js\jquery-1.9.1.min.js">
</script>
<!--<body ondragstart="window.event.returnValue=false;" oncontextmenu="window.event.returnValue=false;" onselectstart="event.returnValue=false;">
-->
<body>
<div id="contentHolder">
	<video id="video" width="320" height="240" autoplay></video>
	<button id="snap" style="display:none">
		拍照
	</button>
	<canvas id="canvas" style="display:;" width="320" height="240"></canvas>
</div>
<button id="snap" onclick="">
	snap
</button>
<button id="update" onclick="PostCode()">
	upload
</button>
<div id="support">
</div>
</body>
<script>
	//判断浏览器是否支持HTML5 Canvas 
	var canvas;
	var context;
	var video;
	var canvansData="";
	window.onload = function() {
		try {
			//动态创建一个canvas元 ，并获取他2Dcontext。如果出现异常则表示不支持
			document.createElement("canvas").getContext("2d");
			$("#support").html("浏览器支持HTML5 CANVAS");
		} catch(e) {
			$("#support").html("浏览器不支持HTML5 CANVAS");
		}
	};
	//这段代 主要是获取摄像头的视频流并显示在Video 签中           
	window.addEventListener("DOMContentLoaded",
	function() {
		canvas = document.getElementById("canvas"),
		context = canvas.getContext("2d"),
		video = document.getElementById("video"),
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
		//这个是拍照按钮的事件，
		$("#snap").get(0).addEventListener("click",
		function() {
			context.drawImage(video, 0, 0, 320, 240);
			
			var imgdata=context.getImageData(0,0,canvas.width,canvas.height);
	        var data=imgdata.data;
			var delta=-65;
		  	 for(var i=0,n=data.length;i<n;i+=4){
		                //var average=(data[i]+data[i+1]+data[i+2])/3;0.393
						var average=0.393*data[i]+ 0.769*data[i+1] + 0.189*data[i+2] + 0;
		                data[i]=average;
		                data[i+1]=average;
		                data[i+2]=average;
						
						//lightness
						data[i] += delta;     // red
						data[i + 1] += delta; // green
						data[i + 2] += delta; // blue
						
							
		    }
			context.putImageData(imgdata,0,0);
			
		});
	},
	false);
	//这个是 刷新上 图像的        
	function PostCode() {
		$('#snap').get(0).click()
		var canvans = document.getElementById("canvas");                    
		//以下开始编 数据   
		var imgData = canvans.toDataURL();
		//将图像转换为base64数据
		//var base64Data = imgData.substr(22);
		//在前端截取22位之后的字符串作为图像数据
		//alert(imgData);
		//开始异步上            
		$.post("<?php echo ($scanUrl); ?>", {
			"img": imgData
		},
		function(data, status) {
			if (status == "success") {
				if (data == "OK") {
					//alert("二维 已经解析");
				} else {
					//alert(data);
				}
			} else {
				alert("数据上 失败");
			}
		},
		"text");
	}
</script>