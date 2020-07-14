<?php
use App\Core\Routing\Router;
use App\Core\Auth;
?>
<!DOCTYPE html>
<html>
    <head>
        <title>
            <?= getConfig("nom_du_site")->getInfo(); ?>
        </title>
        <link href="<?= url('scss/dist/main.css') ?>" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="<?= url('js/navbar.js') ?>"></script>
        <script src="<?= url('js/top.js') ?>"></script>
        <script src="<?= url('js/slider.js') ?>"></script>
    </head>
    <body>
        <header id="navbar" class="navbar navbar--fixed bg-white">
            <a href="<?= Router::getRouteByName('home')->getUrl() ?>"><img src="<?= url('img/logo.png') ?>" style="height:60px"></img></a>

            <nav class="navbar-front">
                <a href="<?= Router::getRouteByName('menus')->getUrl() ?>">Menus</a>
                <a href="#">Réservations</a>
                <a href="<?= Router::getRouteByName('actualites.index')->getUrl() ?>">Actualités</a>
            </nav>

            <div id="navbar-front-mobile" class="navbar-front-mobile">
                <a href="" class="closebtn" onclick="closeNav()">&times;</a>
                <a href="<?= Router::getRouteByName('menus')->getUrl() ?>">Menus</a>
                <a href="#">Réservations</a>
                <a href="<?= Router::getRouteByName('actualites.index')->getUrl() ?>">Actualités</a>
            </div>

            <div style="display: flex; flex-direction: row; align-items: center;"> 
                <label><?= (Auth::isAuthenticated())?Auth::getUser()->getFirstname()." ".Auth::getUser()->getLastname():""; ?></label>
                <div class="dropdown dropdown-front">
                    <button class="btn-dropdown bg-white"><img src="<?= url('img/icones/user.png') ?>"></button>
                    <div class="dropdown-content">
                        <?php if(Auth::isAuthenticated()): ?>
                            <?php if(Auth::getUser()->isAdmin()): ?>
                                <a href="<?= Router::getRouteByName('admin.index')->getUrl() ?>"><img src="<?= url('img/icones/profil.png') ?>"> Administration</a>
                                <?php endif; ?>
                                    <a href="<?= Router::getRouteByName('profile.edit')->getUrl() ?>"><img src="<?= url('img/icones/profil.png') ?>"> Profil</a><hr/>
                                    
                                    <a href="<?= Router::getRouteByName('auth.logout')->getUrl() ?>" *
                                        onclick="event.preventDefault(); 
                                                document.getElementById('logout-form').submit();">
                                            <img src="<?= url('img/icones/logout.png') ?>"> Se déconnecter
                                    </a>

                                    <form id="logout-form" action="<?= Router::getRouteByName('auth.logout')->getUrl() ?>" method="POST" style="display: none;">
                                        <?php csrfInput(); ?>
                                    </form>
                                <?php else: ?>
                            <a href="<?= Router::getRouteByName('auth.show-login')->getUrl() ?>"><img src="<?= url('img/icones/profil.png') ?>"> Connexion</a>
                            <a href="<?= Router::getRouteByName('auth.show-register')->getUrl() ?>"><img src="<?= url('img/icones/profil.png') ?>"> Inscription</a>
                        <?php endif; ?>
                    </div>
                </div>
                <span class="burger" onclick="openNav()">&#9776;</span>
            </div>
        </header>

        <?php include $this->viewPath;?>

        <footer>
            <div class="left">
                <div>
                    <p><a href="<?= Router::getRouteByName('contact.index')->getUrl() ?>">Nous contacter</a></p>
                    <?php if(false != getConfig("facebook")): ?>
                        <a href="<?= getConfig("facebook")->getInfo(); ?>" target="_blank"><img src="img/icones/facebook.png"></a>
                    <?php endif; ?>
                    <?php if(false != getConfig("instagram")): ?>
                        <a href="<?= getConfig("instagram")->getInfo(); ?>" target="_blank"><img src="img/icones/instagram.png"></a>
                    <?php endif; ?>
                    <?php if(false != getConfig("linkedin")): ?>
                        <a href="<?= getConfig("linkedin")->getInfo(); ?>" target="_blank"><img src="img/icones/linkedin.png"></a>
                    <?php endif; ?>
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