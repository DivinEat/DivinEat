<?php
use App\Core\Routing\Router;
?>
<div style="height: 4em;"></div>

<?php if(isset($articles)):
    foreach($articles as $article): ?>
    <div class="row frame">
        <div class="col-sm-12">
            <div class="row"><span><?= $article->getTitle(); ?></span></div>
            <div class="ligne"></div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="col-inner article">
                        <?= $article->getContent(); ?>
                    </div>
                </div>
            </div>
            <div class="row more"><a href="<?= Router::getRouteByName('actualites.show', $article->getId())->getUrl() ?>">Voir plus</a></div>
        </div>
    </div>
    <?php endforeach; 
endif; ?>