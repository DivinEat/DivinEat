<?php

namespace App\Controllers\Admin;

use App\Core\Controller\Controller;
use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\Routing\Router;
use App\Core\View;
use App\Models\Article;
use App\Managers\ArticleManager;

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
        $myView = new View("admin.article.create", "admin");
    }

    public function store(Request $request, Response $response, array $args)
    {
        $data = $_POST;

        $articleManager = new ArticleManager();

        $article = new Article();
        $article->setTitle($data["title"]);
        $article->setContent($data["content"]);
        $article->setDate_inserted(date('Y-m-d H:i:s'));

        $articleManager->save($article);

        Router::redirect('admin.article.index');
    }

    public function edit(Request $request, Response $response, array $args)
    {
        $id = $args["article_id"];

        $articleManager = new ArticleManager();
        $article = $articleManager->find($id);

        $myView = new View("admin.article.edit", "admin");
        $myView->assign("article", $article);
    }

    public function update(Request $request, Response $response, array $args)
    {
        echo "<pre>", var_dump($_POST), "</pre>";
    }

    public function destroy(Request $request, Response $response, array $args)
    {
        $manager = new ArticleManager();
        $manager->delete($args["article_id"]);

        Router::redirect('admin.article.index');
    }
}