<!DOCTYPE html>
	<html>
	<head>
		<title>DivinEat</title>
		<link href="public/scss/dist/main.css" rel="stylesheet">
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
