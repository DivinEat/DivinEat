<?php

namespace App\Forms\Configuration;

use App\Core\Form;
use App\Core\Routing\Router;
use App\Core\Constraints\RequiredConstraint;
use App\Core\Constraints\UniqueConstraint;
use App\Managers\PageManager;
use App\Models\Configuration;

class CreateNavbarElementForm extends Form
{
    public function buildForm()
    {
        $this->setName("createNavbarElementForm");

        $pageManager = new PageManager();
        $pages = $pageManager->findAll();


        $this->setBuilder()
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
                    new UniqueConstraint("pages.slug", "Le slug de la page est déjà utilisé !")
                ],
            ])
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
            ->add("page", "select", [
                "attr" => [
                    "class" => "form-control"
                ],
                "label" => [
                    "value" => "Page",
                    "class" => "",
                ],
                "data" => $pages,
                "getter" => "getTitle",
                "constraints" => [
                    new RequiredConstraint()
                ]
            ])
            ->add("annuler", "link", [
                "attr" => [
                    "href" => Router::getRouteByName("admin.configuration.index")->getUrl(),
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
            ->addConfig("class", Configuration::class)
            ->addConfig("attr", [
                "id" => "createNavbarElementForm",
                "class" => "admin-form",
            ])
            ->addConfig("action", Router::getRouteByName("admin.configuration.navbar.store")->getUrl());
    }
}