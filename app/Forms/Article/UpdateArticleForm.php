<?php

namespace App\Forms\Article;

use App\Core\Form;
use App\Models\Article;
use App\Core\StringValue;
use App\Core\Routing\Router;
use App\Core\Constraints\UniqueConstraint;
use App\Core\Constraints\RequiredConstraint;

class UpdateArticleForm extends Form
{
    public function buildForm()
    {   
        $article = $this->model;

        $this->setName("updateArticleForm");

        if ($article->getPublish() == true) {
            $selectedPublish = new StringValue("Oui", "1");
        } else {
            $selectedPublish = new StringValue("Non", "0");
        }

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
            ->add("publish", "select", [
                "attr" => [
                    "class" => "form-control"
                ],
                "label" => [
                    "value" => "Publier",
                    "class" => "",
                ],
                "data" => [
                    new StringValue("Oui", "1"),
                    new StringValue("Non", "0")
                ],
                "getter" => "getString",
                "selected" => $selectedPublish,
                "constraints" => [
                    new RequiredConstraint()
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
                    "value" => "Mettre à jour",
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