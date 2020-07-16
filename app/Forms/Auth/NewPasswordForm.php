<?php

namespace App\Forms\Auth;

use App\Core\Form;
use App\Core\Routing\Router;
use App\Core\Constraints\PasswordConstraint;
use App\Core\Constraints\RequiredConstraint;

class NewPasswordForm extends Form
{
    public function buildForm()
    {   
        $this->setName("newPasswordForm");

        $this->setBuilder()
            ->add("pwd", "input", [
                "attr" => [
                    "type" => "password",
                    "class" => "form-control form-control-user",
                    ],
                "label" => [
                    "value" => "Nouveau mot de passe",
                    "class" => "",
                ],
                "constraints" => [
                    new PasswordConstraint(),
                    new RequiredConstraint()
                ]
            ])
            ->add("confirmPwd", "input", [
                "attr" => [
                    "type" => "password",
                    "class" => "form-control form-control-user",
                    ],
                "label" => [
                    "value" => "Confirmation du mot de passe",
                    "class" => "",
                ],
                "constraints" => [
                    new PasswordConstraint(),
                    new RequiredConstraint()
                ]
            ])
            ->add("submit", "input", [
                "attr" => [
                    "type" => "submit",
                    "value" => "&#xf1d8;  Valider",
                    "class" => "btn btn-account btn-account-blue margin-top-50"
                ]
            ]);
    }

    public function configureOptions(): void
    {
        $this
            ->addConfig("attr", [
                "id" => "newPasswordForm",
                "class" => "admin-form width-100",
                "name" => "newPasswordForm"
            ])
            ->addConfig("action", Router::getRouteByName("auth.new-password")->getUrl());
    }
}