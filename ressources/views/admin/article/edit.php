<?php use App\Core\Routing\Router;?>

<div class="row">
    <div class="col-sm-12">
        <div class="col-inner">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Modifier un article</h3>
                </div>
                <div class="box-body">
                    <form method="POST" action="<?= Router::getRouteByName('admin.article.update', $article->getId())->getUrl() ?>" id="article-form" class="admin-form">
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <label>Titre</label>
                                <input type="text" name="title" class="form-control" value="<?= (isset($article))?$article->getTitle():'' ?>"/>
                            </div>
                        </div>
                        
                        <input type="hidden" id="editor-content" name="content" class="form-control" value="<?= (isset($article))?$article->getContent():'' ?>"/>

                        <div class="form-group row">
                            <div class="col-sm-12">
                                <label>Contenu</label>
                                <div id="articlejs" class="" style="min-height: 15em; border: 1px solid #ccc;"></div>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <a href="<?= Router::getRouteByName('admin.article.index')->getUrl() ?>" class="btn btn-default">Annuler</a>
                                <input type="submit" class="btn btn-primary" value="Envoyer"/>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>