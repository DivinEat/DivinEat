<?php
use App\Core\Routing\Router;
?>

<div class="total-height" style="margin-top: 4em;">
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
                <div class="row more"><a href="<?= Router::getRouteByName('actualites.index')->getUrl() ?>">Retour</a></div>
            </div>
        </div>
        <?php foreach ($comments as $comment):?>
        <?php if (null !== getAuth() && getAuth()->isAdmin()): ?>
                <form action="<?= route('actualites.comments.hide', [$article->getSlug(), $comment->getId()])->getUrl() ?>" method="post">
                    <?php csrfInput(); ?>
                    <button type="submit" class="btn btn-account-red">Masquer le commentaire</button>
                </form>
        <?php endif; ?>

        <?php if (null !== getAuth() && getAuth()->getId() === $comment->getUser()->getId()): ?>
                <form action="<?= route('actualites.comments.destroy', [$article->getSlug(), $comment->getId()])->getUrl() ?>" method="post">
                    <?php csrfInput(); ?>
                    <button type="submit" class="btn btn-account-red">Supprimer</button>
                </form>
                <form action="<?= route('actualites.comments.update', [$article->getSlug(), $comment->getId()])->getUrl() ?>" method="post">
                    <?php csrfInput(); ?>
                    <textarea name="content" id="" cols="30" rows="10"><?= $comment->getContent() ?></textarea>
                    <button type="submit" class="btn btn-account-blue">Modifier</button>
                </form>
            <?php else:?>
                <p><?= $comment->getContent() ?></p>
            <?php endif;?>
        <?php endforeach;?>
        <form action="<?= route('actualites.comments.store', [$article->getSlug()])->getUrl() ?>" method="post">
            <?php csrfInput(); ?>
            <textarea name="content" id="" cols="30" rows="10" placeholder="Votre commentaire"></textarea>
            <button type="submit" class="btn btn-account-green">Poster</button>
        </form>
    <?php endif; ?>
</div>