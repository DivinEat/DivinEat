<?php

namespace App\Controllers;

use App\Core\View;
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
}