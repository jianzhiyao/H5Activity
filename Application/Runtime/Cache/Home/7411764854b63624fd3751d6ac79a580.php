<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>
			Sign in &middot; Twitter Bootstrap
		</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">
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
		<!-- Le styles -->
		<style type="text/css">
			body { padding-top: 40px; padding-bottom: 40px; background-color: #f5f5f5;
			} .form-signin { max-width: 300px; padding: 19px 29px 29px; margin: 0 auto
			20px; background-color: #fff; border: 1px solid #e5e5e5; -webkit-border-radius:
			5px; -moz-border-radius: 5px; border-radius: 5px; -webkit-box-shadow: 0
			1px 2px rgba(0,0,0,.05); -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05); box-shadow:
			0 1px 2px rgba(0,0,0,.05); } .form-signin .form-signin-heading, .form-signin
			.checkbox { margin-bottom: 10px; } .form-signin input[type="text"], .form-signin
			input[type="password"] { font-size: 16px; height: auto; margin-bottom:
			15px; padding: 7px 9px; }
		</style>
	</head>
	<body>
		<div class="container">
			<form class="form-signin" action="<?php echo ($registUrl); ?>" method="post">
				<h2 class="form-signin-heading">
					欢迎注册
				</h2>
				<input type="text" class="input-block-level" name="username" required placeholder="学号或者工号">
				<input type="text" class="input-block-level" name="name" placeholder="姓名">
				<input type="password" class="input-block-level" name="password1" required placeholder="密　码">
				<input type="password" class="input-block-level" name="password2" required placeholder="再次输入密码">
				<button class="btn btn-large btn-primary " type="submit">
					注册
				</button>
			</form>
		</div>
		<!-- /container -->
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
	</body>

</html>