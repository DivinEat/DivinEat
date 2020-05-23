<h1 class="title">DIVINEAT</h1>

<div class="card">
	<h2 class="title color-purple margin-0">Connexion</h2>
	<p class="subtitle margin-bottom-75">Connectez-vous à votre espace</p>
	
	<?php $this->addModal("form", $configFormUser);?>

	<div class="flex-raw">	
		<a class="btn btn-account btn-account-green" href="<?= helpers::getUrl("User", "register")?>"><i class='fa fa-user-plus'></i>Inscription</a>
		<a class="btn btn-account btn-account-red" href="<?= helpers::getUrl("User", "forgotPwd")?>"><i class='fa fa-lock'></i>Mot de passe</a>
	</div>
</div>

<a href="/" class="btn btn-account">Retour au site</a>