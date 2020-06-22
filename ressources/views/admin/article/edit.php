<?php use App\Core\Routing\Router;?>

<div class="row">
    <div class="col-sm-12">
        <div class="col-inner">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Modifier un article</h3>
                </div>
                <div class="box-body">
                    <?php $this->addModal("form", $configFormArticle); ?>
                </div>
            </div>
        </div>
    </div>
</div>