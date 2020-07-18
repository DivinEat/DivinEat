<?php

use App\Core\Routing\Router; ?>

<div class="row">
    <div class="col-sm-12">
        <div class="col-inner">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Préférences générales</h3>
                </div>
                <div class="box-body">
                    <?php $this->addModal("table_show", $configurationData); ?>
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
                    <h3 class="box-title">Barre de navigation</h3>
                    <a href="<?= Router::getRouteByName('admin.configuration.navbar.create')->getUrl() ?>" class="btn btn-add">Ajouter</a>
                </div>
                <div class="box-body">
                    <?php $this->addModal("table_show", $navbarData); ?>
                </div>
            </div>
        </div>
    </div>
</div>