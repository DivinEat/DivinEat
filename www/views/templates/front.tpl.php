<!DOCTYPE html>
<html>
<head>
	<title>Front</title>
	<link href="public/scss/dist/main.css" rel="stylesheet">
	<script src="public/vendor/jquery/jquery.min.js"></script>
	<script src="public/js/navbar.js"></script>
</head>
<body>
	<header id="navbar" class="navbar bg-white">
		<img src="https://image.freepik.com/vecteurs-libre/restaurant-logo-modele_1236-155.jpg" style="height:100%"></img>
		<nav class="navbar-front">
			<a href="#">Menus</a>
			<a href="#">Réservations</a>
			<a href="#">Actualités</a>
			<a href="" class="icon" onclick="showBars()">
				<i class="fa fa-bars"></i>
			</a>
		</nav>
		<div class="dropdown">
			<button class="dropbtn bg-white"><img src="public/img/icones/user.png"></button>
			<div class="dropdown-content">
				<a href="#"><img src="public/img/icones/profil.png"> Profil</a>
				<a href="#"><img src="public/img/icones/settings.png"> Paramètres</a><hr/>
				<a href="#"><img src="public/img/icones/logout.png"> Se déconnecter</a>
			</div>
		</div>
	</header>

</body>
</html>