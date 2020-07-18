<?php use App\Core\Routing\Router; ?>

<div class="row">
    <div class="col-sm-12">
        <div class="col-inner">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Préférences générales</h3>
                </div>
                <div class="box-body">
                    <form action="<?= route('admin.configuration.sitemap.generate')->getUrl() ?>" method="post">
                        <?php csrfInput(); ?>
                        <button class="btn btn-primary" type="submit">Générer la sitemap</button>
                    </form>
                    <br>
                    <?php $this->addModal("table_show", $configTableConfiguration); ?>
                </div>
            </div>
        </div>
    </div>
</div>