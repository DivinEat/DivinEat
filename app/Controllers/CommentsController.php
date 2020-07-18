<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\Routing\Router;
use App\Managers\ArticleManager;
use App\Managers\CommentManager;
use App\Core\Controller\Controller;
use App\Core\Migration\MigrationRunner;
use App\Forms\Comments\CreateCommentForm;

class CommentsController extends Controller
{
    public function store(Request $request, Response $response, array $args)
    {
        $article = current((new ArticleManager())->findBy(['slug' => $args['article_slug']]));
        if (false === $article)
            return Router::redirect('home');
            
        $request->setInputPrefix('createCommentForm_');

        $comments = (new CommentManager())->findBy(['article' => $article->getId(), 'hide' => false]);

        $form = $response->createForm(CreateCommentForm::class, $article);

        if (false === $form->handle($request))
            return $response->render("article.show", "main", [
                "article" => $article,
                "comments" => $comments,
                "createCommentForm" => $form,
            ]);

        $comment = (new CommentManager())->create([
            'article' => $article->getId(),
            'user' => Auth::getUser()->getId(),
            'content' => $request->get('content'),
        ]);

        return Router::redirect('actualites.show', [$args['article_slug']]);
    }

    public function update(Request $request, Response $response, array $args)
    {
        $comment = (new CommentManager())->find($args['comment_id']);
        if (null === $comment ||$comment->getUser()->getId() !== Auth::getUser()->getId())
            return Router::redirect('home');

        $comment->update(['content' => $request->get('content')]);

        Router::redirect('actualites.show', [$comment->getArticle()->getSlug()]);
    }

    public function destroy(Request $request, Response $response, array $args)
    {
        $comment = (new CommentManager())->find($args['comment_id']);
        if (null === $comment ||$comment->getUser()->getId() !== Auth::getUser()->getId())
            return Router::redirect('home');

        (new CommentManager())->delete($comment->getId());

        Router::redirect('actualites.show', [$comment->getArticle()->getSlug()]);
    }

    public function hide(Request $request, Response $response, array $args)
    {
        $comment = (new CommentManager())->find($args['comment_id']);
        if (null === $comment ||$comment->getUser()->getId() !== Auth::getUser()->getId())
            return Router::redirect('home');

        $comment->update(['hide' => true]);

        Router::redirect('actualites.show', [$comment->getArticle()->getSlug()]);
    }
}