<?php use App\Core\Routing\Router; ?>

<div class="row total-height" style="margin-top: 4em;">
    <div class="col-sm-12">
        <div class="col-inner">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Liste de vos réservations</h3>
                    <a href="<?= Router::getRouteByName('order.create')->getUrl() ?>" class="btn btn-add">Nouvelle réservation</a>
                </div>
                <div class="box-body">
                    <?php $this->addModal("table_show", $configTableOrder); ?>
                </div>
            </div>
        </div>
    </div>
</div>