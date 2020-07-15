<?php

namespace App\Forms\Image;

use App\Core\Form;
use App\Models\Image;
use App\Core\Routing\Router;
use App\Core\Constraints\FileConstraint;
use App\Core\Constraints\RequiredConstraint;

class CreateImageForm extends Form
{
    public function buildForm()
    {   
        $this->setName("createImageForm");

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
                    "href" => Router::getRouteByName("admin.image.index")->getUrl(),
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
            ->addConfig("class", Image::class)
            ->addConfig("attr", [
                "id" => "createImageForm",
                "class" => "admin-form",
                "name" => "createImageForm",
                "enctype" => "multipart/form-data"
            ])
            ->addConfig("action", Router::getRouteByName("admin.image.store")->getUrl());
    }
}