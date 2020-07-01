<?php

namespace App\Controllers;

use App\Core\Controller\Controller;
use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\Builder\QueryBuilder;
use App\Core\View;
use App\Models\Article;
use App\Managers\ArticleManager;

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

        foreach($articles as $article){
            $article->setContent(Article::setJsonToHtml($article->getContent()));
        }

        $myView = new View("article.index", "main");
        $myView->assign("articles", $articles);
    }

    public function show(Request $request, Response $response, array $args)
    {
        $id = $args["article_id"];

        $articleManager = new ArticleManager();
        $article = $articleManager->find($id);
        $article->setContent(Article::setJsonToHtml($article->getContent()));

        $myView = new View("article.show", "main");
        $myView->assign("article", $article);
    }
}