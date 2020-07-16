<?php

namespace App\Forms\Install;

use App\Core\Form;
use App\Core\Routing\Router;
use App\Core\Constraints\EmailConstraint;
use App\Core\Constraints\PasswordConstraint;
use App\Core\Constraints\RequiredConstraint;

class CreateInformationsForm extends Form
{
    public function buildForm()
    {   
        $this->setName("createInformationsForm");

        $this->setBuilder()
            ->add("firstname", "input", [
                "label" => [
                    "value" => "Prénom"
                ],
                "attr" => [
                    "type" => "text",
                    "placeholder"=>"Entrez votre prénom",
                    "class" => "form-control"
                ],
                "constraints" => [
                    new RequiredConstraint()
                ]
            ])
            ->add("lastname", "input", [
                "label" => [
                    "value" => "Nom"
                ],
                "attr" => [
                    "type" => "text",
                    "placeholder"=>"Entrez votre nom",
                    "class" => "form-control"
                ],
                "constraints" => [
                    new RequiredConstraint()
                ]
            ])
            ->add("pwd", "input", [
                "label" => [
                    "value" => "Mot de passe"
                ],
                "attr" => [
                    "type" => "password",
                    "placeholder"=>"Entrez votre mot de passe",
                    "class" => "form-control"
                ],
                "constraints" => [
                    new PasswordConstraint(),
                    new RequiredConstraint()
                ]
            ])
            ->add("confirmPwd", "input", [
                "label" => [
                    "value" => "Confirmation"
                ],
                "attr" => [
                    "type" => "password",
                    "placeholder"=>"Confirmez votre mot de passe",
                    "class" => "form-control"
                ],
                "constraints" => [
                    new PasswordConstraint(),
                    new RequiredConstraint()
                ]
            ])
            ->add("email", "input", [
                "label" => [
                    "value" => "Email"
                ],
                "attr" => [
                    "type" => "text",
                    "placeholder"=>"Entrez votre adresse Email",
                    "class" => "form-control"
                ],
                "constraints" => [
                    new EmailConstraint()
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
                "id" => "createInformationsForm",
                "class" => "admin-form width-100",
                "name" => "createInformationsForm"
            ])
            ->addConfig("action", Router::getRouteByName("install.store-general-form")->getUrl());
    }
}