<!DOCTYPE html>
<html>
<head>
	<title>Dashboard</title>
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
    <link href="public/scss/dist/main.css" rel="stylesheet">
</head>
<body>
    <div class="row padding-0">
        <div class="col-sm-2 padding-0">
            <div class="col-inner sidebar">Sidebar</div>
        </div>
        <div class="col-sm-10 padding-0">
            <div class="row padding-0">
                <div class="col-sm-12 padding-right-0">
                    <div class="col-inner navbar bg-white">
                        <div class="navbar-back">
                            <form class="navbar-search">
                                <input type="text" class="form-control" placeholder="Recherche">
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