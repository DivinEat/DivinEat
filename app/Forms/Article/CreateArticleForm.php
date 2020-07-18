<?php

namespace App\Forms\Article;

use App\Core\Form;
use App\Models\Article;
use App\Core\StringValue;
use App\Core\Routing\Router;
use App\Core\Constraints\LengthConstraint;
use App\Core\Constraints\UniqueConstraint;
use App\Core\Constraints\RequiredConstraint;

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
                    new UniqueConstraint("articles.title", "Le nom de l'article est déjà utilisé !"),
                    new LengthConstraint(2, 255, 'Le titre doit contenir au moins 2 caractères', 'Le titre doit contenir au plus 255 caractères')
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
                    new UniqueConstraint("articles.slug", "Le slug de l'article est déjà utilisé !"),
                    new LengthConstraint(2, 255, 'Le slug doit contenir au moins 2 caractères', 'Le slug doit contenir au plus 255 caractères')
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
                    new StringValue("Oui", 1),
                    new StringValue("Non", 0)
                ],
                "getter" => "getString",
                "constraints" => [
                    new RequiredConstraint()
                ]
            ])
            ->add("content", "input", [
                "attr" => [
                    "type" => "hidden",
                ],
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
