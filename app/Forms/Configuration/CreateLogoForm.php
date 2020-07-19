<?php

namespace App\Forms\Configuration;

use App\Core\Form;
use App\Core\Routing\Router;
use App\Models\Configuration;
use App\Core\Constraints\FileConstraint;
use App\Core\Constraints\RequiredConstraint;

class CreateLogoForm extends Form
{
    public function buildForm()
    {   
        $this->setName("createLogoForm");

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
                    new FileConstraint(),
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
                "id" => "createLogoForm",
                "class" => "admin-form",
                "name" => "createLogoForm",
                "enctype" => "multipart/form-data"
            ])
            ->addConfig("action", Router::getRouteByName("admin.configuration.logo.update")->getUrl());
    }
}