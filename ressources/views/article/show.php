<?php
use App\Core\Routing\Router;
?>

<div class="total-height" style="margin-top: 8em;">
    <?php if(isset($article)): ?>
        <div class="row frame">
            <div class="col-sm-12">
                <div class="row"><span><?= $article->getTitle(); ?></span></div>
                <div class="ligne"></div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="col-inner">
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
                        <a href="<?= Router::getRouteByName('actualites.index')->getUrl() ?>">Retour</a>
                        <?php if (getAuth() !== null && getAuth()->isEditor()): ?>
                        <a href="<?= Router::getRouteByName('editor.actualites.edit', [$article->getCategorie()->getSlug(), $article->getSlug()])->getUrl() ?>">Modifier</a>
                        <?php endif;?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 center">
                <div class="col-inner flex-column">
                    <div class="card">
                        <p class="subtitle margin-bottom-50">Commentaires</p>
                        <?php foreach ($comments as $comment):?>
                            <div class="flex-raw flex-raw-start">
                            <?php if (null !== getAuth() && getAuth()->isModOrAdmin()): ?>
                                    <form action="<?= route('actualites.comments.hide', [$article->getCategorie()->getSlug(), $article->getSlug(), $comment->getId()])->getUrl() ?>" method="post">
                                        <?php csrfInput(); ?>
                                        <button type="submit" class="btn btn-remove">Masquer le commentaire</button>
                                    </form>
                            <?php endif; ?>

                            <?php if (null !== getAuth() && getAuth()->getId() === $comment->getUser()->getId()): ?>
                                <form action="<?= route('actualites.comments.destroy', [$article->getCategorie()->getSlug(), $article->getSlug(), $comment->getId()])->getUrl() ?>" method="post">
                                    <?php csrfInput(); ?>
                                    <button type="submit" class="btn btn-remove">Supprimer</button>
                                </form>
                                </div>
                                
                                <form class="admin-form width-100" action="<?= route('actualites.comments.update', [$article->getCategorie()->getSlug(), $article->getSlug(), $comment->getId()])->getUrl() ?>" method="post">
                                    <?php csrfInput(); ?>
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <label class="">Commentaire - <?= $comment->getUser()->getFirstname() . " " . $comment->getUser()->getLastname()?></label>
                                            <button type="submit" class="btn btn-edit">Modifier</button>
                                            <textarea class="form-control form-control-textarea" name="content" cols="30" rows="10"><?= $comment->getContent() ?></textarea>
                                        </div>
                                    </div>
                                </form>
                            <?php else:?>
                                </div>
                                <p><?= $comment->getContent() ?></p>
                            <?php endif;?>
                        <?php endforeach;?>

                        <?php $this->formView("createCommentForm", "comments", "commentForm"); ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>