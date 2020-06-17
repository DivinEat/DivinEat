<?php use App\Core\Routing\Router; ?>

<h1 class="title">DIVINEAT</h1>

<div class="card">
	<h2 class="title color-purple margin-0">Erreur</h2>
    <p class="subtitle margin-bottom-75">Erreur 404</p>
    
    
		<div class="row">
			<div class="col-sm-12 margin-bottom-75">
                <?= "Impossible d'accèder à la page : <b>".$uri."</b>" ?>
            </div>
        </div>
</div>

<a href="<?= Router::getRouteByName('home')->getUrl() ?>" class="btn btn-account">Retour au site</a>