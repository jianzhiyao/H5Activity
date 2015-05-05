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
		<center>
		<video id="video" width="320" height="240" autoplay>
		</video>
		<canvas id="canvas" width="320" height="240">
			你的浏览器不支持CANVAS
		</canvas>
		<br>
		<span id="tips"></span>
		</center>
		
		<button id="click">
			click
		</button>
	</body>
	<script>
		var dotNum=5;
		face = new Face();
		face.playVideo("video");
		button = document.getElementById("click");
		$("#click").on("click",getDataAndPost);
		function getDataAndPost() {
			tips("检测中");
			dot=1;
			var itv=setInterval(function(){
				tips("检测中");
				for(var i=0;i<dot%dotNum+1;i++)
				{
					tipsAppend(".");
				}
				dot++;
			},300);
			face.postCanvasData("canvas", "<?php echo ($scanUrl); ?>",
			function(data) {
				clearInterval(itv);
				var jsonObj=JSON.parse(data);
				var status=jsonObj.status;
				var msg=jsonObj.msg;
				var Obj=jsonObj.body;
				if(Math.floor(status/100)==1)//成功
				{
					tips("与你相似的人有"+Obj.candidate.length+"个");
					tipsAppend("<br>他们的号码是：");
					for(x in Obj.candidate)
					{
						tipsAppend("<br>"+Obj.candidate[x].personid);
					}
					
				}
				else//失败
				{
					tips('<font color="red">' + msg + '</font>');
				}
			},
			function() {
				alert("请求失败！")
			});
		}
		function tips(msg){
			$("#tips").html(msg);
		}
		function tipsAppend(msg){
			$("#tips").html($("#tips").html()+msg);
		}
	</script>

</html>