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
            ->add("db_host", "input", [
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
            ->add("db_name", "input", [
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
            ->add("db_user", "input", [
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
            ->add("db_pwd", "input", [
                "label" => [
                    "value" => "Mot de passe"
                ],
                "attr" => [
                    "type" => "password",
                    "placeholder"=>"Ex : u!-divineat123",
                    "class" => "form-control"
                ],
                "constraints" => [
                    new RequiredConstraint()
                ]
            ])
            ->add("db_prefix", "input", [
                "label" => [
                    "value" => "Préfix"
                ],
                "attr" => [
                    "type" => "text",
                    "placeholder"=>"dve_",
                    "class" => "form-control"
                ],
                "constraints" => [
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