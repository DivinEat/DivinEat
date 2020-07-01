<?php

namespace App\Forms\Contact;

use App\Core\Form;
use App\Core\Routing\Router;
use App\Core\Constraints\LengthConstraint;
use App\Core\Constraints\RequiredConstraint;
use App\Core\Constraints\EmailConstraint;

class CreateContactForm extends Form
{
    public function buildForm()
    {   
        $this->setName("createContactForm");

        $this->setBuilder()
            ->add("email", "input", [
                "attr" => [
                    "type" => "email",
                    "placeholder"=>"&#xf2be;  Adresse Email",
                    "class" => "form-control form-control-user"
                ],
                "constraints" => [
                    new EmailConstraint(),
                    new RequiredConstraint()
                ]
            ])
            ->add("objet", "input", [
                "attr" => [
                    "type" => "text",
                    "placeholder"=>"&#xf0e5;  Objet",
                    "class" => "form-control form-control-user"
                ],
                "constraints" => [
                    new RequiredConstraint()
                ]
            ])
            ->add("text", "input", [
                "attr" => [
                    "type" => "textArea",
                    "placeholder"=>"&#xf0e5;  Ecrire ici",
                    "class" => "form-control form-control-textarea form-control-user"
                ],
                "constraints" => [
                    new RequiredConstraint()
                ]
            ])
            ->add("submit", "input", [
                "attr" => [
                    "type" => "submit",
                    "value" => "&#xf1d8 Envoyer",
                    "class" => "btn btn-account btn-account-blue margin-top-50"
                ]
            ]);
    }

    public function configureOptions(): void
    {
        $this->addConfig("attr", [
                "id" => "createContactForm",
                "class" => "admin-form width-100",
                "name" => "createContactForm"
            ])
            ->addConfig("action", Router::getRouteByName("contact.store")->getUrl());
    }
}