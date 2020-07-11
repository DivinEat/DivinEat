<?php

namespace App\Forms\Article;

use App\Core\Form;
use App\Core\Routing\Router;
use App\Core\Constraints\LengthConstraint;
use App\Core\Constraints\RequiredConstraint;
use App\Core\Constraints\UniqueConstraint;
use App\Models\Article;

class CreateArticleForm extends Form
{
    public function buildForm()
    {   
        $this->setName("createArticleForm");

        $this->setBuilder()
            ->add("title", "input", [
                "label" => [
                    "value" => "Titre",
                    "class" => "",
                ],
                "attr" => [
                    "type" => "text",
                    "class" => "form-control"
                ],
                "constraints" => [
                    new RequiredConstraint(),
                    new UniqueConstraint("articles.title", "Le nom de l'article est déjà utilisé !")
                ]
            ])
            ->add("slug", "input", [
                "label" => [
                    "value" => "Slug",
                    "class" => "",
                ],
                "attr" => [
                    "type" => "text",
                    "class" => "form-control"
                ],
                "constraints" => [
                    new RequiredConstraint(),
                    new UniqueConstraint("articles.slug", "Le slug de l'article est déjà utilisé !")
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
                "id" => "createArticleForm",
                "class" => "admin-form",
                "name" => "createArticleForm"
            ])
            ->addConfig("action", Router::getRouteByName("admin.article.store")->getUrl());
    }
}