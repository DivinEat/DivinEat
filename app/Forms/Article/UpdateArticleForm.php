<?php

namespace App\Forms\Article;

use App\Core\Form;
use App\Core\Routing\Router;
use App\Core\Constraints\RequiredConstraint;
use App\Core\Constraints\UniqueConstraint;
use App\Models\Article;

class UpdateArticleForm extends Form
{
    public function buildForm()
    {   
        $article = $this->model;

        $this->setName("updateArticleForm");

        $this->setBuilder()
            ->add("id", "input", [
                "attr" => [
                    "type" => "hidden",
                    "value" => $article->getId()
                ],
            ])
            ->add("title", "input", [
                "label" => [
                    "value" => "Titre",
                    "class" => "",
                ],
                "attr" => [
                    "type" => "text",
                    "value" => $article->getTitle(),
                    "class" => "form-control"
                ],
                "constraints" => [
                    new RequiredConstraint(),
                    new UniqueConstraint("articles.title", "Le nom de l'article est déjà utilisé !", $article->getId())
                ]
            ])
            ->add("slug", "input", [
                "label" => [
                    "value" => "Slug",
                    "class" => "",
                ],
                "attr" => [
                    "type" => "text",
                    "value" => $article->getSlug(),
                    "class" => "form-control"
                ],
                "constraints" => [
                    new RequiredConstraint(),
                    new UniqueConstraint("articles.slug", "Le slug de l'article est déjà utilisé !", $article->getId())
                ]
            ])
            ->add("annuler", "link", [
                "attr" => [
                    "href" => Router::getRouteByName("admin.article.index")->getUrl(),
                    "class" => "btn btn-default",
                ],
                "text" => "Annuler",
            ])
            ->add("submit", "input", [
                "attr" => [
                    "type" => "submit",
                    "value" => "Ajouter",
                    "class" => "btn btn-primary"
                ]
            ]);
    }

    public function configureOptions(): void
    {
        $this
            ->addConfig("class", Article::class)
            ->addConfig("attr", [
                "id" => "updateArticleForm",
                "class" => "admin-form",
                "name" => "updateArticleForm"
            ])
            ->addConfig("action", Router::getRouteByName("admin.article.update", $this->model->getId())->getUrl());
    }
}