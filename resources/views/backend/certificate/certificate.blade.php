<!DOCTYPE html>
<html lang="en">
<head>
	<title>CERTIFICATE</title>
	<style>
		@page {
			margin: 0;
			padding: 0;
		}
		body {
			
		}
		body:before {
			display: block;
			position: fixed;
			top: -1in; right: -1in; bottom: -1in; left: -1in;
			background-image: url('{{$certs->background}}');
			background-size: 100% 100%;
			background-repeat: no-repeat;
			content: "";
			z-index: -1000;
		}
		.container {
			/* width: 100vw;
			height: 100vh; */
			position: absolute;
			top: 50%;
			left: 50%;
			-moz-transform: translateX(-50%) translateY(-50%);
			-webkit-transform: translateX(-50%) translateY(-50%);
			transform: translateX(-50%) translateY(-50%);
		}
	</style>
</head>
<body>
	<div class="container">
		<?=$contents?>
	</div>
</body>
</html>