<?php

namespace App\Forms\Page;

use App\Core\Form;
use App\Models\Page;
use App\Core\Routing\Router;
use App\Core\Constraints\RequiredConstraint;

class UpdatePageForm extends Form
{
    public function buildForm()
    {
        $page = $this->model;

        $this->setName("updatePageForm");

        $this->setBuilder()
            ->add("data", "input", [
                "attr" => [
                    "type" => "hidden",
                    "value" => $page->getData()
                ],
                "constraints" => [
                    new RequiredConstraint()
                ]
            ])
            ->add("title", "input", [
                "attr" => [
                    "type" => "text",
                    "class" => "form-control",
                    "value" => $page->getTitle(),
                ],
                "label" => [
                    "value" => "Titre",
                ],
                "constraints" => [
                    new RequiredConstraint()
                ]
            ])
            ->add("annuler", "link", [
                "attr" => [
                    "href" => Router::getRouteByName("admin.page.index")->getUrl(),
                    "class" => "btn btn-default",
                ],
                "text" => "Annuler",
            ])
            ->add("submit", "input", [
                "attr" => [
                    "type" => "submit",
                    "value" => "Mettre à jour",
                    "class" => "btn btn-primary",
                ]
            ]);
    }

    public function configureOptions(): void
    {
        $this
            ->addConfig("class", Page::class)
            ->addConfig("attr", [
                "id" => "updatePageForm",
                "class" => "admin-form width-100",
                "name" => "updatePageForm"
            ])
            ->addConfig("action", Router::getRouteByName("admin.page.update", $this->model->getId())->getUrl());
    }
}
