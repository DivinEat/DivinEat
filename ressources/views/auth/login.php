<?php
use App\Core\Routing\Router;
?>

<h1 class="title"><?= getConfig("nom_du_site")->getInfo(); ?></h1>

<div class="card">
	<h2 class="title color-purple margin-0">Connexion</h2>
	<p class="subtitle margin-bottom-75">Connectez-vous à votre espace</p>
	
	<?php $this->formView("loginForm", "auth", "loginForm"); ?>

	<div class="flex-raw">	
		<a class="btn btn-account btn-account-green" href="<?= Router::getRouteByName('auth.show-register')->getUrl() ?>"><i class='fa fa-user-plus'></i>Inscription</a>
		<a class="btn btn-account btn-account-red" href="<?= Router::getRouteByName('auth.show-forgot-password')->getUrl() ?>"><i class='fa fa-lock'></i>Mot de passe</a>
	</div>
</div>

<a href="<?= Router::getRouteByName('home')->getUrl() ?>" class="btn btn-account">Retour au site</a>