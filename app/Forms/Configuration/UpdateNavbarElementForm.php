<?php

namespace App\Forms\Configuration;

use App\Core\Form;
use App\Core\Routing\Router;
use App\Managers\PageManager;
use App\Models\Configuration;
use App\Core\Constraints\RequiredConstraint;

class UpdateNavbarElementForm extends Form
{
    public function buildForm()
    {
        $model = $this->model;

        $this->setName("updateNavbarElementForm");

        $pageManager = new PageManager();
        $pages = $pageManager->findAll();
        $selectedPage = $model->getPage();

        $this->setBuilder()
            ->add("id", "input", [
                "attr" => [
                    "type" => "hidden",
                    "value" => $model->getId()
                ],
                "constraints" => [
                    new RequiredConstraint()
                ]
            ])
            ->add("name", "input", [
                "label" => [
                    "value" => 'Name',
                    "class" => "",
                ],
                "attr" => [
                    "type" => "text",
                    "value" => $model->getName(),
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
                    "value" => $model->getSlug(),
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
                "selected" => $selectedPage,
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
                    "value" => "Mettre à jour",
                    "class" => "btn btn-primary"
                ]
            ]);
    }

    public function configureOptions(): void
    {
        $this
            ->addConfig("class", Configuration::class)
            ->addConfig("attr", [
                "id" => "updateNavbarElementForm",
                "class" => "admin-form",
                "name" => "updateNavbarElementForm"
            ])
            ->addConfig("action", Router::getRouteByName("admin.configuration.navbar.update", $this->model->getId())->getUrl());
    }
}
