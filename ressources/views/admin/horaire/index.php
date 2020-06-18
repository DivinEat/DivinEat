<?php use App\Core\Routing\Router; ?>

<div class="row">
    <div class="col-sm-12">
        <div class="col-inner">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Liste des horaires</h3>
                    <a href="<?= Router::getRouteByName('admin.horairecreate')->getUrl() ?>" class="btn btn-add">Ajouter</a>
                </div>
                <div class="box-body">
                    <?php $this->addModal("table_show", $configTableHoraire); ?>
                </div>
            </div>
        </div>
    </div>
</div>