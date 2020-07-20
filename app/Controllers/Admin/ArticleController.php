<?php

namespace App\Controllers\Admin;

use App\Core\Controller\Controller;
use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\Routing\Router;
use App\Core\View;
use App\Core\Auth;
use App\Managers\UserManager;
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

        $configTableArticle = $this->getArticleData($articles);

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

        $article = $request->getParams(["content", "title", "slug"]);
        $article["author"] = Auth::getUser()->getId();
        
        $article = (new Article())->hydrate($article);
        $article->setPublish(intval($request->get('publish')));

        $form = $response->createForm(CreateArticleForm::class, $article);

        if (false === $form->handle($request))
            return $response->render("admin.article.create", "admin", ["createArticleForm" => $form]);

        (new ArticleManager())->save($article);
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
        $request->setInputPrefix('updateArticleForm_');

        if (null === (new ArticleManager())->find($args['article_id']))
            return Router::redirect('admin.article.index');

        $article = (new Article())->hydrate($request->getParams(['slug', 'title', 'content', 'categorie']));
        $article->setPublish(intval($request->get('publish')));
        $article->setId($args['article_id']);

        $form = $response->createForm(UpdateArticleForm::class, $article);

        if (false === $form->handle($request))
            return $response->render("admin.article.edit", "admin", ["updateArticleForm" => $form]);

        (new ArticleManager())->save($article);

        return Router::redirect('admin.article.edit', [$args['article_id']]);
    }

    public function destroy(Request $request, Response $response, array $args)
    {
        $manager = new ArticleManager();
        $manager->delete($args["article_id"]);

        Router::redirect('admin.article.index');
    }

    private function getArticleData($articles)
    {
        $tabArticles = [];
        foreach ($articles as $article) {

            $author = (new UserManager)->find($article->getAuthor()->getId());

            $tabArticles[] = [
                "title" => $article->getTitle(),
                "slug" => $article->getSlug(),
                "publish" => ($article->getPublish() == true) ? "Oui" : "Non",
                "author" => $author->getLastname() . " " . $author->getFirstname(),
                "categorie" => $article->getCategorie()->getName(),
                "created_at" => $article->getCreatedAt(),
                "updated_at" => $article->getUpdatedAt(),
                "edit" => Router::getRouteByName('admin.article.edit', $article->getId()),
                "destroy" => Router::getRouteByName('admin.article.destroy', $article->getId()),
            ];
        }

        $tab = [
            "config" => [
                "class" => "admin-table"
            ],

            "colonnes" => [
                "Catégorie",
                "Title",
                "Slug",
                "Publié",
                "Auteur",
                "Catégorie",
                "Posté le",
                "Modifié le",
                "Actions"
            ],

            "fields" => [
                "Article" => []
            ]
        ];

        $tab["fields"]["Article"] = $tabArticles;

        return $tab;
    }
}