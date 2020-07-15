<?php

namespace App\Forms\Install;

use App\Core\Form;
use App\Core\Routing\Router;
use App\Core\Constraints\RequiredConstraint;

class CreateSMTPForm extends Form
{
    public function buildForm()
    {   
        $this->setName("createSMTPForm");

        $this->setBuilder()
            ->add("smtp_host", "input", [
                "label" => [
                    "value" => "SMTP Host"
                ],
                "attr" => [
                    "type" => "text",
                    "class" => "form-control"
                ],
                "constraints" => [
                    new RequiredConstraint()
                ]
            ])
            ->add("smtp_port", "input", [
                "label" => [
                    "value" => "SMTP Port"
                ],
                "attr" => [
                    "type" => "number",
                    "class" => "form-control"
                ],
                "constraints" => [
                    new RequiredConstraint()
                ]
            ])
            ->add("smtp_user", "input", [
                "label" => [
                    "value" => "SMTP Utilisateur"
                ],
                "attr" => [
                    "type" => "text",
                    "class" => "form-control"
                ]
            ])
            ->add("smtp_pass", "input", [
                "label" => [
                    "value" => "SMTP Mot de passe"
                ],
                "attr" => [
                    "type" => "password",
                    "class" => "form-control"
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
                "id" => "createSMTPForm",
                "class" => "admin-form width-100",
                "name" => "createSMTPForm"
            ])
            ->addConfig("action", Router::getRouteByName("install.store-smtp-form")->getUrl());
    }
}