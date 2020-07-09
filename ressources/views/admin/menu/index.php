<?php
use App\Core\Routing\Router;
?>
<div class="row">
    <div class="col-sm-12">
        <div class="col-inner">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Gestion des menus</h3>
                    <a href="<?= Router::getRouteByName('admin.menu.create')->getUrl() ?>" class="btn btn-add">Ajouter un menu</a>
                    <a href="<?= Router::getRouteByName('admin.elementmenu.create')->getUrl() ?>" class="btn btn-add">Ajouter un élément de menu</a>
                </div>
                <div class="box-body">
                    <h4 class="box-title">Liste des menus</h4>
                    <?php $this->addModal("menu_list", $configTableMenu); ?>
                    <h4 class="box-title">Liste des éléments de menus</h4>
                    <?php $this->addModal("menu_list", $configTableElementMenu); ?>
                </div>
            </div>
        </div>
    </div>
</div>