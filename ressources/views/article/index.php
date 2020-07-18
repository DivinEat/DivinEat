<?php
use App\Core\Routing\Router;
?>

<div class="total-height" style="margin-top: 4em;">
    <div class="row" style="margin-top: 4em;">
        <div class="col-sm-12 center">
            <div class="col-inner flex-column">
                <div class="card">
                    <h2 class="title color-black margin-50">Actualités</h2>

                    <?php if(isset($articles) && $articles != false):
                        foreach($articles as $article): ?>
                            <div class="row frame width-100">
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
                                    <div class="flex-raw">
                                        <div class="flex-column flex-column-start"> 
                                            <small>Auteur : <?= $article->getAuthor()->getFirstname() . " " . $article->getAuthor()->getLastname(); ?></small>
                                            <small class="color-grey">Catégorie : <?= $article->getCategorie()->getName() ?></small>
                                        </div>
                                        <div class="more">
                                            <a href="<?= Router::getRouteByName('actualites.show', $article->getSlug())->getUrl() ?>">Voir plus</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; 
                    else: ?>
                        <p class="subtitle margin-bottom-50">Aucune actualité n'a été postée</p>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</div>