<?php
    if(C('LAYOUT_ON')) {
        echo '{__NOLAYOUT__}';
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8">
	<title>跳转提示</title>
	<meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">

	<link rel="stylesheet" type="text/css" href="__PUBLIC__/lib/bootstrap/css/bootstrap.css">

	<link rel="stylesheet" type="text/css" href="__PUBLIC__/stylesheets/theme.css">
	<link rel="stylesheet" href="__PUBLIC__/lib/font-awesome/css/font-awesome.css">

	<script src="__PUBLIC__/lib/jquery-1.7.2.min.js" type="text/javascript"></script>

	<!-- Demo page code -->

	<style type="text/css">
		#line-chart {
			height:300px;
			width:800px;
			margin: 0px auto;
			margin-top: 1em;
		}
		.brand { font-family: georgia, serif; }
		.brand .first {
			color: #ccc;
			font-style: italic;
		}
		.brand .second {
			color: #fff;
			font-weight: bold;
		}
	</style>

	<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<!-- Le fav and touch icons -->
	<link rel="shortcut icon" href="../assets/ico/favicon.ico">
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
	<link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
</head>

<!--[if lt IE 7 ]> <body class="ie ie6"> <![endif]-->
<!--[if IE 7 ]> <body class="ie ie7 http-error"> <![endif]-->
<!--[if IE 8 ]> <body class="ie ie8 http-error"> <![endif]-->
<!--[if IE 9 ]> <body class="ie ie9 http-error"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<body class="http-error">
<!--<![endif]-->
<div class="row-fluid">
	<div class="http-error">
		<div class="http-error-message">
			<div class="error-caption">
				<p>Errors!</p>
			</div>
			<div class="error-message">
				<div class="system-message">
					<?php if(isset($message)) { ?>
					<p class="error"><?php echo($message); ?></p>
					<?php }else{ ?>
					<p class="success-strong"> <?php echo($error); ?> </p>
					<?php }?>
					<p class="return-home">
						页面自动 <a id="href" href="<?php echo($jumpUrl); ?>">跳转</a> 等待时间：
						<b id="wait"><?php echo($waitSecond); ?></b>
					</p>

				</div>
			</div>
		</div>
	</div>
</div>

<script src="__PUBLIC__/lib/bootstrap/js/bootstrap.js"></script>
<script type="text/javascript">
	$("[rel=tooltip]").tooltip();
	$(function() {
		$('.demo-cancel-click').click(function(){return false;});
	});
</script>
<script type="text/javascript">
	(function(){
		var wait = document.getElementById('wait'),href = document.getElementById('href').href;
		var interval = setInterval(function(){
			var time = --wait.innerHTML;
			if(time <= 0) {
				location.href = href;
				clearInterval(interval);
			};
		}, 1000);
	})();
</script>
</body>
</html>




