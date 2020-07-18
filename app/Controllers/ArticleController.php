<?php

namespace App\Controllers;

use App\Core\Controller\Controller;
use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\Builder\QueryBuilder;
use App\Core\Routing\Router;
use App\Core\View;
use App\Managers\CommentManager;
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


        $myView = new View("article.index", "main");
        $myView->assign("articles", $articles);
    }

    public function show(Request $request, Response $response, array $args)
    {
        $article = current((new ArticleManager())->findBy(['slug' => $args["article_slug"]]));
        if (! $article)
            return Router::redirect('actualites.index');

        $comments = (new CommentManager())->findBy(['article' => $article->getId(), 'hide' => false]);

        $myView = new View("article.show", "main");
        $myView->assign("article", $article);
        $myView->assign("comments", $comments);
    }
}