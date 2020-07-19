<?php

use App\Core\Routing\Router;
use App\Core\Auth;
?>

<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>
    <link rel="icon" href="<?= getFaviconPath() ?>>" />
    <link href="<?= url('scss/dist/main.css') ?>" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="<?= url('js/navbar.js') ?>"></script>
    <?php $this->getAdditionalJs() ?>
</head>

<body>
    <div class="row padding-0">
        <div class="col-sm-2 padding-0">
            <div class="col-inner sidebar">
                <nav class="sidebar-nav">
                    <a href="<?= Router::getRouteByName('admin.index')->getUrl() ?>" class="sidebar-link">Dashboard<img src='<?= url('/img/icones/arrow.svg') ?>'></a>
                    <a href="<?= Router::getRouteByName('admin.article.index')->getUrl() ?>" class="sidebar-link">Articles<img src='<?= url('img/icones/arrow.svg') ?>'></a>
                    <a href="<?= Router::getRouteByName('admin.categorie.index')->getUrl() ?>" class="sidebar-link">Catégories<img src='<?= url('img/icones/arrow.svg') ?>'></a>
                    <a href="<?= Router::getRouteByName('admin.image.index')->getUrl() ?>" class="sidebar-link">Images<img src='<?= url('img/icones/arrow.svg') ?>'></a>
                    <a href="<?= Router::getRouteByName('admin.page.index')->getUrl() ?>" class="sidebar-link">Pages<img src='<?= url('img/icones/arrow.svg') ?>'></a>
                    <a href="<?= Router::getRouteByName('admin.user.index')->getUrl() ?>" class="sidebar-link">Utilisateurs<img src='<?= url('/img/icones/arrow.svg') ?>'></a>
                    <a href="<?= Router::getRouteByName('admin.menu.index')->getUrl() ?>" class="sidebar-link">Menus<img src='<?= url('/img/icones/arrow.svg') ?>'></a>
                    <a href="<?= Router::getRouteByName('admin.horaire.index')->getUrl() ?>" class="sidebar-link">Horaires<img src='<?= url('/img/icones/arrow.svg') ?>'></a>
                    <a href="<?= Router::getRouteByName('admin.order.index')->getUrl() ?>" class="sidebar-link">Commandes<img src='<?= url('/img/icones/arrow.svg') ?>'></a>
                    <a href="<?= Router::getRouteByName('admin.configuration.index')->getUrl() ?>" class="sidebar-link">Paramètres<img src='<?= url('/img/icones/arrow.svg') ?>'></a>
                    <nav>
            </div>
        </div>

        <div class="col-sm-10 padding-0">
            <div class="row padding-0">
                <div class="col-sm-12 padding-right-0 padding-left-0">
                    <div class="col-inner navbar bg-white">
                        <div class="navbar-back">
                            <a class="computer" href="<?= Router::getRouteByName('home')->getUrl() ?>">
                                <img src="<?= url('img/icones/computer.png') ?>">
                                <span><?= getConfig("nom_du_site")->getInfo(); ?></span>
                            </a>
                        </div>

                        <div style="display: flex; flex-direction: row; align-items: center;">
                            <label><?= (Auth::isAuthenticated()) ? Auth::getUser()->getFirstname() . " " . Auth::getUser()->getLastname() : ""; ?></label>
                            <div class="dropdown">
                                <button class="btn-dropdown bg-white"><img src="<?= url('img/icones/user.png') ?>"></button>
                                <div class="dropdown-content">
                                    <?php if (Auth::isAuthenticated()) : ?>
                                        <?php if (Auth::getUser()->isAdmin()) : ?>
                                            <a href="<?= Router::getRouteByName('admin.index')->getUrl() ?>"><img src="<?= url('img/icones/profil.png') ?>"> Administration</a>
                                        <?php endif; ?>
                                        <a href="<?= Router::getRouteByName('profile.edit')->getUrl() ?>"><img src="<?= url('img/icones/profil.png') ?>"> Profil</a>
                                        <hr />

                                        <a href="<?= Router::getRouteByName('auth.logout')->getUrl() ?>" * onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                            <img src="<?= url('img/icones/logout.png') ?>"> Se déconnecter
                                        </a>

                                        <form id="logout-form" action="<?= Router::getRouteByName('auth.logout')->getUrl() ?>" method="POST" style="display: none;">
                                            <?php csrfInput(); ?>
                                        </form>
                                    <?php else : ?>
                                        <a href="<?= Router::getRouteByName('auth.show-login')->getUrl() ?>"><img src="<?= url('img/icones/profil.png') ?>"> Connexion</a>
                                        <a href="<?= Router::getRouteByName('auth.show-register')->getUrl() ?>"><img src="<?= url('img/icones/profil.png') ?>"> Inscription</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="col-inner">
                        <?php include $this->viewPath; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>