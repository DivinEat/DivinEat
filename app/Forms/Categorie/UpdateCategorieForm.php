<?php

namespace App\Forms\Categorie;

use App\Core\Form;
use App\Core\Routing\Router;
use App\Core\Constraints\RequiredConstraint;
use App\Core\Constraints\UniqueConstraint;

class UpdateCategorieForm extends Form
{
    public function buildForm()
    {
        $model = $this->model;
        $this->setName("updateCategorieForm");

        $this->setBuilder()
            ->add("name", "input", [
                "label" => [
                    "value" => "Nom",
                    "class" => "",
                ],
                "attr" => [
                    "type" => "text",
                    "class" => "form-control",
                    "value" => $model->getName()
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
                    "class" => "form-control",
                    "value" => $model->getSlug()

                ],
                "constraints" => [
                    new RequiredConstraint(),
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
                    "value" => "Mettre à jour",
                    "class" => "btn btn-primary"
                ]
            ]);
    }

    public function configureOptions(): void
    {
        $this
            ->addConfig("class", Categorie::class)
            ->addConfig("attr", [
                "id" => "updateCategorieForm",
                "class" => "admin-form",
            ])
            ->addConfig("action", Router::getRouteByName("admin.categorie.update", $this->model->getId())->getUrl());
    }
}