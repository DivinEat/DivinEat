<?php

namespace App\Forms\Auth;

use App\Core\Form;
use App\Core\Routing\Router;
use App\Core\Constraints\EmailConstraint;
use App\Core\Constraints\LengthConstraint;
use App\Core\Constraints\UniqueConstraint;
use App\Core\Constraints\PasswordConstraint;
use App\Core\Constraints\RequiredConstraint;

class RegisterForm extends Form
{
    public function buildForm()
    {   
        $this->setName("registerForm");

        $this->setBuilder()
            ->add("firstname", "input", [
                "attr" => [
                    "type" => "text",
                    "placeholder"=>"&#xf007;  Prénom",
                    "class" => "form-control form-control-user",
                ],
                "constraints" => [
                    new LengthConstraint(2, 50, "Votre prénom doit contenir au moins 2 caractères.", "Votre prénom doit contenir au plus 50 caractères."),
                    new RequiredConstraint()
                ]
            ])
            ->add("lastname", "input", [
                "required" => true,
                "attr" => [
                    "type" => "text",
                    "class" => "form-control form-control-user",
                    "placeholder"=>"&#xf007;  Nom"
                ],
                "constraints" => [
                    new LengthConstraint(2, 100, "Votre nom doit contenir au moins 2 caractères.", "Votre nom doit contenir au plus 100 caractères."),
                    new RequiredConstraint()
                ]
            ])
            ->add("email", "input", [
                "required" => true,
                "attr" => [
                    "type" => "email",
                    "class" => "form-control form-control-user",
                    "placeholder"=>"&#xf2be;  Adresse Email"
                ],
                "constraints" => [
                    new EmailConstraint(),
                    new UniqueConstraint("users.email", "L'email est déjà utilisé !"),
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
            ->add("pwdConfirm", "input", [
                "attr" => [
                    "type" => "password",
                    "class" => "form-control form-control-user",
                    "placeholder"=>"&#xf023;  Confirmation du mot de passe",
                ],
                "constraints" => [
                    new PasswordConstraint(),
                    new RequiredConstraint()
                ]
            ])
            ->add("submit", "input", [
                "attr" => [
                    "type" => "submit",
                    "value" => "&#xf007;  Inscription",
                    "class" => "btn btn-account btn-account-blue margin-top-50"
                ]
            ]);
    }

    public function configureOptions(): void
    {
        $this
            ->addConfig("attr", [
                "id" => "registerForm",
                "class" => "admin-form width-100",
                "name" => "registerForm"
            ])
            ->addConfig("action", Router::getRouteByName("auth.register")->getUrl());
    }
}