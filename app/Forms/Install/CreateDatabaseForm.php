<?php

namespace App\Forms\Install;

use App\Core\Form;
use App\Core\Routing\Router;
use App\Core\Constraints\PasswordConstraint;
use App\Core\Constraints\RequiredConstraint;

class CreateDatabaseForm extends Form
{
    public function buildForm()
    {   
        $this->setName("createDatabaseForm");

        $this->setBuilder()
            ->add("adress", "input", [
                "label" => [
                    "value" => "Adresse de la base de données"
                ],
                "attr" => [
                    "type" => "text",
                    "placeholder"=>"Ex : localhost",
                    "class" => "form-control"
                ],
                "constraints" => [
                    new RequiredConstraint()
                ]
            ])
            ->add("name", "input", [
                "label" => [
                    "value" => "Nom de la base de données"
                ],
                "attr" => [
                    "type" => "text",
                    "placeholder"=>"Ex : divineat",
                    "class" => "form-control"
                ],
                "constraints" => [
                    new RequiredConstraint()
                ]
            ])
            ->add("user", "input", [
                "label" => [
                    "value" => "Nom d'utilisateur"
                ],
                "attr" => [
                    "type" => "text",
                    "placeholder"=>"Ex : u-divineat",
                    "class" => "form-control"
                ],
                "constraints" => [
                    new RequiredConstraint()
                ]
            ])
            ->add("pwd", "input", [
                "label" => [
                    "value" => "Nom d'utilisateur"
                ],
                "attr" => [
                    "type" => "password",
                    "placeholder"=>"Ex : u!-divineat123",
                    "class" => "form-control"
                ],
                "constraints" => [
                    new PasswordConstraint(),
                    new RequiredConstraint()
                ]
            ])
            ->add("submit", "input", [
                "attr" => [
                    "type" => "submit",
                    "value" => "Enregistrer",
                    "class" => "btn btn-add right"
                ]
            ]);
    }

    public function configureOptions(): void
    {
        $this
            ->addConfig("attr", [
                "id" => "createDatabaseForm",
                "class" => "admin-form width-100",
                "name" => "createDatabaseForm"
            ])
            ->addConfig("action", Router::getRouteByName("install.store-database-form")->getUrl());
    }
}