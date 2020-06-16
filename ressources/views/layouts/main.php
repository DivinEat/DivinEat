<!DOCTYPE html>
<html>
<head>
    <title>Front</title>
    <link href="<?= url('scss/dist/main.css') ?>" rel="stylesheet">
    
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="<?= url('js/navbar.js') ?>"></script>
    <script src="<?= url('js/top.js') ?>"></script>
    <script src="<?= url('js/slider.js') ?>"></script>
</head>
<body>
<header id="navbar" class="navbar navbar--fixed bg-white">
    <img src="#" style="height:100%"></img>

    <nav class="navbar-front">
        <a href="#">Menus</a>
        <a href="#">Réservations</a>
        <a href="#">Actualités</a>
        </a>
    </nav>

    <div id="navbar-front-mobile" class="navbar-front-mobile">
        <a href="" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="#">Menus</a>
        <a href="#">Réservations</a>
        <a href="#">Actualités</a>
    </div>

    <div class="dropdown dropdown-front">
        <button class="btn-dropdown bg-white"><img src="img/icones/user.png"></button>
        <div class="dropdown-content">
            <a href="#"><img src="img/icones/profil.png"> Profil</a>
            <a href="#"><img src="img/icones/settings.png"> Paramètres</a><hr/>
            <a href="#"><img src="img/icones/logout.png"> Se déconnecter</a>
        </div>
    </div>
    <span class="burger" onclick="openNav()">&#9776;</span>
</header>

<?php include $this->viewPath;?>

<footer>
    <div class="left">
        <div>
            <p><a href="#" target="_blank">Nous contacter</a></p>
            <a href="#" target="_blank"><img src="img/icones/linkedin.png"></a>
            <a href="#" target="_blank"><img src="img/icones/facebook.png"></a>
            <a href="#" target="_blank"><img src="img/icones/instagram.png"></a>
        </div>
    </div>
    <div class="right">
        <button class="btn-footer" id="scroll_to_top">
            <div class="circle">
                <span class="arrow up"></span><br>
                Top
            </div>
        </button>
    </div>
    </div>
</footer>
</body>
</html>