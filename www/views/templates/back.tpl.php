<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link href="public/scss/dist/main.css" rel="stylesheet">
    <script src="public/vendor/jquery/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.js"></script>
    <!-- <script src="public/js/dashboard/dashboard-graphs.js"></script> -->
    <script src="public/js/navbar.js"></script>
    <script type="module" src="public/js/pageBuilder.js"></script>
    <!-- <script src="public/js/component/textEditor.js"></script> -->
    <script src="public/js/utils.js"></script>
</head>
<body>
    <div class="row padding-0">
        <div class="col-sm-2 padding-0">
            <div class="col-inner sidebar">
                <nav class="sidebar-nav">
                    <a href="" class="sidebar-link">Dashboard<img src='public/img/arrow.svg'></a>
                    <a href="" class="sidebar-link">Articles<img src='public/img/arrow.svg'></a>
                    <a href="" class="sidebar-link">Menus<img src='public/img/arrow.svg'></a>
                    <a href="" class="sidebar-link">Réservations<img src='public/img/arrow.svg'></a>
                    <a href="" class="sidebar-link">Plans<img src='public/img/arrow.svg'></a>
                    <a href="" class="sidebar-link">Utilisateurs<img src='public/img/arrow.svg'></a>
                    <a href="" class="sidebar-link">Paramètres<img src='public/img/arrow.svg'></a>
                <nav>
            </div>
        </div>

        <div class="col-sm-10 padding-0">
            <div class="row padding-0">
                <div class="col-sm-12 padding-right-0 padding-left-0">
                    <div class="col-inner navbar bg-white">
                        <div class="navbar-back">
                            <form class="navbar-search">
                                <span class="search-icon"><img src="public/img/icones/search.png"></span>
                                <input class="form-control" type="text" placeholder="Recherche">
                            </form>

                            <a class="computer" href="#">
                                <img src="public/img/icones/computer.png">
                                <span>DivinEat</span>
                            </a>
                        </div>

                        <div class="dropdown">
                            <button class="dropbtn bg-white"><img src="public/img/icones/user.png"></button>
                            <div class="dropdown-content">
                                <a href="#"><img src="public/img/icones/profil.png"> Profil</a>
                                <a href="#"><img src="public/img/icones/settings.png"> Paramètres</a><hr/>
                                <a href="#"><img src="public/img/icones/logout.png"> Se déconnecter</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="col-inner">
                        <?php include "views/".$this->view.".view.php";?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>