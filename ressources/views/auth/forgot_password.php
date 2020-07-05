<?php
use App\Core\Routing\Router;
use App\Core\Builder\QueryBuilder;
use App\Models\Configuration;

$config =  (new QueryBuilder())
    ->select('*')
    ->from('configurations', 'c')
    ->where("libelle = :nom")
    ->setParameter('nom', 'nom_du_site')
    ->getQuery()
    ->getArrayResult(Configuration::class);

$nom_du_site = $config[0]->getInfo();
?>

<h1 class="title"><?= $nom_du_site ?></h1>

<div class="card">
	<h2 class="title color-purple margin-0">Mot de passe</h2>
	<p class="subtitle margin-bottom-75">Veuillez renseigner votre adresse email</p>
	
	<?php $this->formView("forgotPasswordForm", "auth", "forgotPasswordForm"); ?>
</div>

<a href="<?= Router::getRouteByName('home')->getUrl() ?>" class="btn btn-account">Retour au site</a>