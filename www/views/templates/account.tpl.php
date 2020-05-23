<!DOCTYPE html>
	<html>
	<head>
		<title>DivinEat</title>
		<link href="public/scss/dist/main.css" rel="stylesheet">
		<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
		<script src="public/vendor/jquery/jquery.min.js"></script>
	</head>

	<body class="bg-main">
		<div class="row">
			<div class="col-sm-5 center">
				<div class="col-inner flex-column">
					<?php include "views/".$this->view.".view.php";?>
				</div>
			</div>
		</div>
	</body>
</html>
