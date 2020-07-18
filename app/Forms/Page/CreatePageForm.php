<?php

namespace App\Forms\Page;

use App\Core\Form;
use App\Models\Page;
use App\Core\Routing\Router;
use App\Core\Constraints\RequiredConstraint;

class CreatePageForm extends Form
{
    public function buildForm()
    {
        $this->setName("createPageForm");

        $this->setBuilder()
            ->add("data", "input", [
                "attr" => [
                    "type" => "hidden",
                ],
                "constraints" => [
                    new RequiredConstraint()
                ]
            ])
            ->add("title", "input", [
                "attr" => [
                    "type" => "text",
                    "class" => "form-control",
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
                    "value" => "Nouvelle page",
                    "class" => "btn btn-primary",
                ]
            ]);
    }

    public function configureOptions(): void
    {
        $this
            ->addConfig("class", Page::class)
            ->addConfig("attr", [
                "id" => "createPageForm",
                "class" => "admin-form width-100",
                "name" => "udpateProfileForm"
            ])
            ->addConfig("action", Router::getRouteByName('admin.page.store')->getUrl());
    }
}
