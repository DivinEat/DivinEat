<?php
use App\Core\Routing\Router;
?>
<div class="row">
    <div class="col-sm-12">
        <div class="col-inner">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Gestion des pages</h3>
                    <a href="<?= Router::getRouteByName('admin.page.create')->getUrl() ?>" class="btn btn-add">Ajouter une page</a>
                </div>
                <div class="box-body">
                    <h4 class="box-title">Liste des pages</h4>
                    <?php $this->addModal("table_show", $dataIndex); ?>
                </div>
            </div>
        </div>
    </div>
</div>