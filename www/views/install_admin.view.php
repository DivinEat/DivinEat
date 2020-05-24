<h1 class="title">DIVINEAT</h1>

<div class="card">
	<p class="subtitle">Configuration du compte Administrateur</p>

    <form method="POST" action="<?= helpers::getUrl("Test", "admin") ?>" class="admin-form width-100">
	    <div class="form-group row">
            <div class="col-sm-12">

                <label>Pseudo</label>
                <input type="text" name="pseudo" placeholder="Entrez votre pseudo" class="form-control margin-bottom-25">

                <label>Mot de passe</label>
                <input type="text" name="password" placeholder="Entrez votre mot de passe" class="form-control margin-bottom-25">

                <label>Confirmation</label>
                <input type="text" name="confirm-password" placeholder="Confirmez votre mot de passe" class="form-control margin-bottom-25">

                <label>Email</label>
                <input type="text" name="email" placeholder="Entrez votre adresse Email" class="form-control margin-bottom-25">

                <input type="submit" class="btn btn-add right" value="Enregistrer">
            </div>

            <div class="progress">
                <div class="progress-75"></div> 
            </div>
        </div>
    </form> 
	
</div>