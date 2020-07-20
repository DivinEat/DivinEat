<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\View;
use App\Forms\EditorArticle\CreateEditorArticleForm;
use App\Forms\EditorArticle\UpdateEditorArticleForm;
use App\Models\Article;
use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\Routing\Router;
use App\Managers\ArticleManager;
use App\Managers\CommentManager;
use App\Core\Builder\QueryBuilder;
use App\Core\Controller\Controller;
use App\Forms\Comments\CreateCommentForm;
use App\Forms\Comments\UpdateCommentForm;

class ArticleController extends Controller
{
    public function index(Request $request, Response $response)
    {
        $articles =  (new QueryBuilder())
            ->select('*')
            ->from('articles', 'a')
            ->orderBy('id', 'DESC')
            ->getQuery()
            ->getArrayResult(Article::class);


        $myView = new View("article.index", "main");
        $myView->assign("articles", $articles);
    }

    public function show(Request $request, Response $response, array $args)
    {
        $article = current((new ArticleManager())->findBy(['slug' => $args["article_slug"]]));
        if (! $article)
            return Router::redirect('actualites.index');

        $comments = (new CommentManager())->findBy(['article' => $article->getId(), 'hide' => false]);

        $formCreate = $response->createForm(CreateCommentForm::class, $article);

        $response->render("article.show", "main", [
            "article" => $article,
            "comments" => $comments,
            "createCommentForm" => $formCreate
        ]);
    }

    public function create(Request $request, Response $response)
    {
        $form = $response->createForm(CreateEditorArticleForm::class);

        $response->render("admin.article.create", "main", ["createArticleForm" => $form]);
    }

    public function store(Request $request, Response $response, array $args)
    {
        $request->setInputPrefix('createArticleForm_');

        $article = $request->getParams(["content", "title", "slug"]);
        $article["author"] = Auth::getUser()->getId();

        $article = (new Article())->hydrate($article);
        $article->setPublish(intval($request->get('publish')));

        $form = $response->createForm(CreateEditorArticleForm::class, $article);

        if (false === $form->handle($request))
            return $response->render("admin.article.create", "main", ["createArticleForm" => $form]);

        (new ArticleManager())->save($article);

        return Router::redirect('actualites.index');
    }

    public function edit(Request $request, Response $response, array $args)
    {
        $article = current((new ArticleManager())->findBy(['slug' => $args['article_slug']]));
        if (! $article)
            return Router::redirect('actualites.index');

        $form = $response->createForm(UpdateEditorArticleForm::class, $article);

        $response->render("admin.article.edit", "main", ["updateArticleForm" => $form]);
    }

    public function update(Request $request, Response $response, array $args)
    {
        $request->setInputPrefix('updateArticleForm_');

        $article = current((new ArticleManager())->findBy(['slug' => $args['article_slug']]));
        if (! $article)
            return Router::redirect('actualites.index');

        $article->setSlug($request->get('slug'));
        $article->setTitle($request->get('title'));
        $article->setContent($request->get('content'));
        $article->setPublish(intval($request->get('publish')));

        $form = $response->createForm(UpdateEditorArticleForm::class, $article);

        if (false === $form->handle($request))
            return $response->render("admin.article.edit", "admin", ["updateArticleForm" => $form]);

        (new ArticleManager())->save($article);

        return Router::redirect('editor.actualites.edit', [$args['categorie_slug'], $article->getSlug()]);
    }
}