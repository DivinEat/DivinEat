<?php

namespace App\Forms\Configuration;

use App\Core\Form;
use App\Core\Routing\Router;
use App\Models\Configuration;
use App\Core\Constraints\FileConstraint;
use App\Core\Constraints\RequiredConstraint;

class CreateImageForm extends Form
{
    public function buildForm()
    {   
        $this->setName("createConfigurationForm");

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
                "id" => "createConfigurationForm",
                "class" => "admin-form",
                "name" => "createConfigurationForm",
                "enctype" => "multipart/form-data"
            ])
            ->addConfig("action", Router::getRouteByName("admin.configuration.slider.store")->getUrl());
    }
}