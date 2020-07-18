<?php

namespace App\Controllers\Admin;

use App\Core\Controller\Controller;
use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\Routing\Router;
use App\Core\View;
use App\Core\Auth;
use App\Models\Article;
use App\Managers\ArticleManager;
use App\Forms\Article\CreateArticleForm;
use App\Forms\Article\UpdateArticleForm;

class ArticleController extends Controller
{
    public function index(Request $request, Response $response)
    {
        $articleManager = new ArticleManager();
        $articles = $articleManager->findAll();

        $configTableArticle = Article::getShowArticleTable($articles);

        $myView = new View("admin.article.index", "admin");
        $myView->assign("configTableArticle", $configTableArticle);
    }

    public function create(Request $request, Response $response, array $args)
    {
        $form = $response->createForm(CreateArticleForm::class);

        $response->render("admin.article.create", "admin", ["createArticleForm" => $form]);
    }

    public function store(Request $request, Response $response, array $args)
    {
        $request->setInputPrefix('createArticleForm_');

        $fields = $request->getParams(["content", "title", "slug", "publish"]);
        $fields["author"] = Auth::getUser()->getId();

        $object = (new Article())->hydrate($fields);

        $form = $response->createForm(CreateArticleForm::class, $object);

        if (false === $form->handle($request))
            return $response->render("admin.article.create", "admin", ["createArticleForm" => $form]);

        (new ArticleManager())->save($object);
        dd((new ArticleManager())->findAll());
        return Router::redirect('admin.article.index');
    }

    public function edit(Request $request, Response $response, array $args)
    {
        $article = (new ArticleManager())->find($args['article_id']);
        if (null === $article)
            return Router::redirect('admin.article.index');

        $form = $response->createForm(UpdateArticleForm::class, $article);

        $response->render("admin.article.edit", "admin", ["updateArticleForm" => $form]);
    }

    public function update(Request $request, Response $response, array $args)
    {
        $article = (new ArticleManager())->find($args['article_id']);
        if (null === $article)
            return Router::redirect('admin.article.index');

        $request->setInputPrefix('updateArticleForm_');

        $article = (new Article)->hydrate([
            'id' => $article->getId(),
            'content' => $request->get("content"),
            'title' => $request->get("title"),
            'slug' => $request->get("slug"),
            'publish' => intval($request->get("publish")),
        ]);

        $form = $response->createForm(UpdateArticleForm::class, $article);

        if (false === $form->handle($request)) {
            $response->render("admin.article.edit", "admin", ["updateArticleForm" => $form]);
        } else {
            (new ArticleManager())->save($article);
            Router::redirect('admin.article.index');
        }
    }

    public function destroy(Request $request, Response $response, array $args)
    {
        $manager = new ArticleManager();
        $manager->delete($args["article_id"]);

        Router::redirect('admin.article.index');
    }
}
