<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>
			Insert title here
		</title>
		<script src="/activity/Public\js\jquery-1.9.1.min.js">
		</script>
		<script src="/activity/Public\js\Face.js">
		</script>
	</head>
	<body>
		<video id="video" width="320" height="240" autoplay>
		</video>
		<canvas id="canvas" width="320" height="240">
			你的浏览器不支持CANVAS
		</canvas>
		<button id="click">
			click
		</button>
	</body>
	<script>
		face = new Face();
		face.playVideo("video");
		button = document.getElementById("click");
		$("#click").on("click",
		function() {
			face.postCanvasData("canvas", "<?php echo ($scanUrl); ?>",
			function(data) {
				var jsonObj;
			},
			function() {
				alert("请求失败！")
			});
		});
	</script>

</html>