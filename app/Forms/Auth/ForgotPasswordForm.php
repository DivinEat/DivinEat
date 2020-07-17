<?php

namespace App\Forms\Auth;

use App\Core\Form;
use App\Core\Routing\Router;
use App\Core\Constraints\EmailConstraint;
use App\Core\Constraints\RequiredConstraint;

class ForgotPasswordForm extends Form
{
    public function buildForm()
    {   
        $this->setName("forgotPasswordForm");

        $this->setBuilder()
            ->add("email", "input", [
                "required" => true,
                "attr" => [
                    "type" => "email",
                    "class" => "form-control form-control-user",
                    "placeholder"=>"&#xf2be;  Adresse Email"
                ],
                "constraints" => [
                    new EmailConstraint(),
                    new RequiredConstraint()
                ]
            ])
            ->add("submit", "input", [
                "attr" => [
                    "type" => "submit",
                    "value" => "&#xf1d8;  Envoyer la demande",
                    "class" => "btn btn-account btn-account-blue margin-top-50"
                ]
            ]);
    }

    public function configureOptions(): void
    {
        $this
            ->addConfig("attr", [
                "id" => "forgotPasswordForm",
                "class" => "admin-form width-100",
                "name" => "forgotPasswordForm"
            ])
            ->addConfig("action", Router::getRouteByName("auth.forgot-password")->getUrl());
    }
}