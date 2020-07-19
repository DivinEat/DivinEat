<?php

namespace App\Forms\Configuration;

use App\Core\Form;
use App\Core\Routing\Router;
use App\Models\Configuration;
use App\Core\Constraints\FaviconConstraint;
use App\Core\Constraints\RequiredConstraint;

class CreateFaviconForm extends Form
{
    public function buildForm()
    {   
        $this->setName("createFaviconForm");

        $this->setBuilder()
            ->add("file", "input", [
                "label" => [
                    "value" => "Image",
                ],
                "attr" => [
                    "type" => "file",
                    "placeholder"=>"Ajouter une image",
                    "class" => "form-control"
                ],
                "constraints" => [
                    new FaviconConstraint(),
                    new RequiredConstraint()
                ]
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
                "id" => "createFaviconForm",
                "class" => "admin-form",
                "name" => "createFaviconForm",
                "enctype" => "multipart/form-data"
            ])
            ->addConfig("action", Router::getRouteByName("admin.configuration.favicon.update")->getUrl());
    }
}