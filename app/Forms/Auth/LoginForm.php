<?php

namespace App\Forms\Auth;

use App\Core\Form;
use App\Core\Routing\Router;
use App\Core\Constraints\EmailConstraint;
use App\Core\Constraints\LengthConstraint;
use App\Core\Constraints\PasswordConstraint;
use App\Core\Constraints\RequiredConstraint;

class LoginForm extends Form
{
    public function buildForm()
    {   
        $this->setName("loginForm");

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
            ->add("pwd", "input", [
                "attr" => [
                    "type" => "password",
                    "class" => "form-control form-control-user",
                    "placeholder"=>"&#xf084;  Mot de passe"
                ],
                "constraints" => [
                    new PasswordConstraint(),
                    new RequiredConstraint()
                ]
            ])
            ->add("submit", "input", [
                "attr" => [
                    "type" => "submit",
                    "value" => "&#xf0c2;  Connexion",
                    "class" => "btn btn-account btn-account-blue margin-top-50"
                ]
            ]);
    }

    public function configureOptions(): void
    {
        $this
            ->addConfig("attr", [
                "id" => "loginForm",
                "class" => "admin-form width-100",
                "name" => "loginForm"
            ])
            ->addConfig("action", Router::getRouteByName("auth.login")->getUrl());
    }
}