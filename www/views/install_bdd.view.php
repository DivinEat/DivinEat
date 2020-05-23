<h1 class="title">DIVINEAT</h1>

<div class="card">
	<h2 class="title color-purple margin-0">Bienvenue</h2>
	<p class="subtitle">Merci d'avoir choisi notre CMS</p>

    <form method="POST" action="<?= helpers::getUrl("Test", "admin") ?>" class="admin-form width-100">
	    <div class="form-group row">
            <div class="col-sm-12">

                <label>Adresse de la base de données</label>
                <input type="text" name="adress" placeholder="Ex : localhost" class="form-control margin-bottom-25">

                <label>Nom de la base de données</label>
                <input type="text" name="name" placeholder="Ex : divineat" class="form-control margin-bottom-25">

                <label>Nom d'utilisateur</label>
                <input type="text" name="user" placeholder="Ex : u-divineat" class="form-control margin-bottom-25">

                <label>Mot de passe</label>
                <input type="text" name="password" placeholder="Ex : u!-divineat123" class="form-control margin-bottom-25">

                <input type="submit" class="btn btn-add right" value="Enregistrer">
            </div>

            <div class="progress">
                <div class="progress-50"></div> 
            </div>
        </div>
    </form> 
	
</div>