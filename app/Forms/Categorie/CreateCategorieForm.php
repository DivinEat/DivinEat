<?php

namespace App\Forms\Categorie;

use App\Core\Form;
use App\Core\Routing\Router;
use App\Core\Constraints\SlugConstraint;
use App\Core\Constraints\UniqueConstraint;
use App\Core\Constraints\RequiredConstraint;

class CreateCategorieForm extends Form
{
    public function buildForm()
    {
        $this->setName("createCategorieForm");

        $this->setBuilder()
            ->add("name", "input", [
                "label" => [
                    "value" => "Nom",
                    "class" => "",
                ],
                "attr" => [
                    "type" => "text",
                    "class" => "form-control"
                ],
                "constraints" => [
                    new RequiredConstraint()
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
                    new SlugConstraint(),
                    new UniqueConstraint("categorie.slug", "Le slug de la catégorie est déjà utilisé !")
                ],
            ])
            ->add("annuler", "link", [
                "attr" => [
                    "href" => Router::getRouteByName("admin.categorie.index")->getUrl(),
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
            ->addConfig("class", Categorie::class)
            ->addConfig("attr", [
                "id" => "createCategorieForm",
                "class" => "admin-form",
            ])
            ->addConfig("action", Router::getRouteByName("admin.categorie.store")->getUrl());
    }
}