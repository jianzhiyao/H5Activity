<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="A preview of the jQuery UI Bootstrap theme">
		<meta name="author" content="Addy Osmani">
		<!-- Le styles -->
		<link href="/activity/Public/jquery-ui-bootstrap/assets/css/bootstrap.min.css"
		rel="stylesheet">
		<link type="text/css" href="/activity/Public/jquery-ui-bootstrap/css/custom-theme/jquery-ui-1.10.0.custom.css"
		rel="stylesheet" />
		<link type="text/css" href="/activity/Public/jquery-ui-bootstrap/assets/css/font-awesome.min.css"
		rel="stylesheet" />
		<!--[if IE 7]>
			<link rel="stylesheet" href="assets/css/font-awesome-ie7.min.css">
		<![endif]-->
		<!--[if lt IE 9]>
			<link rel="stylesheet" type="text/css" href="css/custom-theme/jquery.ui.1.10.0.ie.css"
			/>
		<![endif]-->
		<link href="/activity/Public/jquery-ui-bootstrap/assets/css/docs.css" rel="stylesheet">
		<link href="/activity/Public/jquery-ui-bootstrap/assets/js/google-code-prettify/prettify.css"
		rel="stylesheet">
		<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
			<script src="http://html5shim.googlecode.com/svn/trunk/html5.js">
			</script>
		<![endif]-->
		<title>
			Insert title here
		</title>
		<script src="/activity/Public\js\jquery-1.9.1.min.js">
		</script>
		<script src="/activity/Public\js\Face.js">
		</script>
	</head>
	<body>
		<center>
			<video id="video" width="320" height="240" autoplay>
			</video>
			<canvas id="canvas" width="320" height="240">
				你的浏览器不支持CANVAS
			</canvas>
			<br>
			<div id="h-slider" style="width:50%;"></div>
			亮度设置:<input id="lightness" type="number" value="-65"><button id="click">检测</button>
			<br>
			<span id="tips">
			</span>
			
			<br>
			
			
			
		</center>
	</body>
	<script src="/activity/Public/jquery-ui-bootstrap/assets/js/jquery-1.9.0.min.js"
	type="text/javascript">
	</script>
	<script src="/activity/Public/jquery-ui-bootstrap/assets/js/bootstrap.min.js"
	type="text/javascript">
	</script>
	<script src="/activity/Public/jquery-ui-bootstrap/assets/js/jquery-ui-1.10.0.custom.min.js"
	type="text/javascript">
	</script>
	<script src="/activity/Public/jquery-ui-bootstrap/assets/js/google-code-prettify/prettify.js"
	type="text/javascript">
	</script>
	<script>
		var $lightness = -65;
		var dotNum = 5;
		face = new Face();
		face.playVideo("video");
		button = document.getElementById("click");

		$("#click").on("click", getDataAndPost);
		
		$('#click').button();
		$('#h-slider').slider({
			    range: true,
				range: "min",
			    min: -100,
			    max: 100,
			    value:-65,
				slide: function (event, ui) {
			        $("#lightness").val(ui.value);
					$lightness=parseInt(ui.value);
					face.setLightness($lightness);
					face.setCanvas("canvas");
			    },
			});

		function getDataAndPost() {
			tips("检测中");
			dot = 1;
			var itv = setInterval(function() {
				tips("检测中");
				for (var i = 0; i < dot % dotNum + 1; i++) {
					tipsAppend(".");
				}
				dot++;
			},
			300);
			face.postCanvasData("canvas", "<?php echo ($scanUrl); ?>",
			function(data) {
				clearInterval(itv);
				var jsonObj = JSON.parse(data);
				var status = jsonObj.status;
				var msg = jsonObj.msg;
				var Obj = jsonObj.body;
				if (Math.floor(status / 100) == 1) //成功
				{
					tips("与你相似的人有" + Obj.candidate.length + "个");
					tipsAppend("<br>他们的号码是：");
					for (x in Obj.candidate) {
						tipsAppend("<br>" + Obj.candidate[x].personid + ",相似度是" + Obj.candidate[x].confidence);
					}

				} else //失败
				{
					tips('<font color="red">' + msg + '</font>');
				}
			},
			function() {
				alert("请求失败！")
			});
		}
		function tips(msg) {
			$("#tips").html(msg);
		}
		function tipsAppend(msg) {
			$("#tips").html($("#tips").html() + msg);
		}
	</script>

</html>