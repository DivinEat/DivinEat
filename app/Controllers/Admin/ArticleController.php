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
use App\Managers\UserManager;
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
        $data = $_POST;

        foreach($data as $elementName => $element) {
            $data[explode("_", $elementName)[1]] = $data[$elementName];
            unset($data[$elementName]);
        }
        
        $article = (new Article())->hydrate($data);
        $article->setDate_inserted(date('Y-m-d H:i:s'));
        $article->setAuthor(Auth::getUser());

        $form = $response->createForm(CreateArticleForm::class, $article);
        
        if (false === $form->handle($request)) {
            $response->render("admin.article.create", "admin", ["createArticleForm" => $form]);
        } else {
            (new ArticleManager())->save($article);       
            Router::redirect('admin.article.index');
        }
    }

    public function edit(Request $request, Response $response, array $args)
    {
        $id = $args["article_id"];

        if(isset($id)){
            $articleManager = new ArticleManager();
            $article = $articleManager->find($id);
        } else {
            throw new \Exception("L'id de l'article n'existe pas.");
        }
        
        $form = $response->createForm(UpdateArticleForm::class, $article);

        $response->render("admin.article.edit", "admin", ["updateArticleForm" => $form]);
    }

    public function update(Request $request, Response $response, array $args)
    {
        $data = $_POST;

        foreach($data as $elementName => $element) {
            $data[explode("_", $elementName)[1]] = $data[$elementName];
            unset($data[$elementName]);
        }
        
        $articleOld = (new ArticleManager())->find($data["id"]);
        $article = (new Article())->hydrate($data);
        $article->setDate_updated(date('Y-m-d H:i:s'));
        $article->setDate_inserted($articleOld->getDate_inserted());
        $article->setAuthor($articleOld->getAuthor());

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