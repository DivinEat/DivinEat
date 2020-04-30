<div class="row">
    <div class="col-sm-12">
        <div class="col-inner">
            <a class="btn btn-remove">Supprimer</a>
            <a class="btn btn-default">Annuler</a>
            <a class="btn btn-add">Ajouter</a>
            <a class="btn btn-edit">Modifier</a>
            <a class="btn btn-primary">Envoyer</a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="col-inner">
            <div class="alert alert-danger">
                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                Danger ! This is an alert box.
            </div>
            <div class="alert alert-success">
                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                Success ! This is an alert box.
            </div>
            <div class="alert alert-info">
                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                Info ! This is an alert box.
            </div>
            <div class="alert alert-warning">
                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                Warning ! This is an alert box.
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="col-inner">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Ajouter un article</h3>
                </div>
                <div class="box-body">
                    <?php $this->addModal("form", $configFormMenu );?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="col-inner">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Modifier un article</h3>
                </div>
                <div class="box-body">
                    <?php $this->addModal("form", $configFormMenu );?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="col-inner">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Liste des article</h3>
                </div>
                <div class="box-body">
                    <?php $this->addModal("table-show", $configTableMenu );?>
                </div>
            </div>
        </div>
    </div>
</div>

