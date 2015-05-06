<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
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
		</title>
		<script src="/activity/Public\js\jquery-1.9.1.min.js">
		</script>
		<script src="/activity/Public\js\Face.js">
		</script>
	</head>
	<body>
		<center>
			<video id="video" style="display:;" width="320" height="240" autoplay>
			</video>
			<canvas id="canvas" width="320" height="240">
				你的浏览器不支持CANVAS
			</canvas>
			<br>
			<div id="h-slider" style="width:50%;">
			</div>
			亮度设置:
			<input id="lightness" type="number" value="-65">
			<button id="click" class="btn btn-success">
				检测
			</button>
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
		face = new Face();
		face.playVideo("video");
		button = document.getElementById("click");

		$("#click").on("click", getDataAndPost);

		$('#h-slider').slider({
			range: true,
			range: "min",
			min: -100,
			max: 100,
			value: -65,
			slide: function(event, ui) {
				$("#lightness").val(ui.value);
				$lightness = parseInt(ui.value);
				face.setLightness($lightness);
			},
		});
		window.onload = function() {
			setInterval(function() {
				face.setCanvas("canvas");
			},
			40);
		};

		function getDataAndPost() {
			var itv = waitingTips("请等待");
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
					tipsAppend("<br>请选择你的号码:");
					for (x in Obj.candidate) {
						tipsAppend('<br><input type="button"  value="' + Obj.candidate[x].personid + '" class="btn" onclick="signup(this.value,\''+Obj.face_id+'\')">');
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
		function waitingTips(msg, dotNum) {
			dotNum = arguments[1] ? arguments[1] : 5;
			tips(msg);
			dot = 1;
			var itv = setInterval(function() {
				tips(msg);
				for (var i = 0; i < dot % dotNum + 1; i++) {
					tipsAppend(".");
				}
				dot++;
			},
			300);
			return itv;
		}
		function signup(person_id, face_id) {
			$.post("<?php echo ($singupUrl); ?>", {
				"person_id": person_id,
				"face_id": face_id,
				"activity_id": "<?php echo ($activity_id); ?>"
			},
			function(data, status) {
				if (status == "success") {
					var jsonObj=JSON.parse(data);
					if(Math.ceil(jsonObj.status/100)==1)
					{
						//成功
						tips(jsonObj.msg);
					}
					else
					{
						//失败
						tips(jsonObj.msg);
					}
				} else {
					
				}
			},
			"text");
		}
	</script>

</html>