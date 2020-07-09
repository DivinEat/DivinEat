<?php

namespace App\Forms\User;

use App\Core\Form;
use App\Models\User;
use App\Core\Routing\Router;
use App\Core\Constraints\EmailConstraint;
use App\Core\Constraints\LengthConstraint;
use App\Core\Constraints\PasswordConstraint;
use App\Core\Constraints\RequiredConstraint;

class UpdateProfileForm extends Form
{
    public function buildForm()
    {
        $user = $this->model;

        $this->setName("udpateProfileForm");
        
        $this->setBuilder()
            ->add("id", "input", [
                "attr" => [
                    "type" => "hidden",
                    "value" => $user->getId()
                ],
            ])
            ->add("firstname", "input", [
                "label" => [
                    "value" => "Prénom",
                    "class" => "",
                ],
                "attr" => [
                    "type" => "text",
                    "class" => "form-control",
                    "value" => $user->getFirstname()
                ],
                "constraints" => [
                    new LengthConstraint(2, 50, "Votre prénom doit contenir au moins 2 caractères.", "Votre prénom doit contenir au plus 50 caractères."),
                    new RequiredConstraint()
                ]
            ])
            ->add("lastname", "input", [
                "label" => [
                    "value" => "Nom",
                    "class" => "",
                ],
                "required" => true,
                "attr" => [
                    "type" => "text",
                    "class" => "form-control",
                    "value" => $user->getLastName()
                ],
                "constraints" => [
                    new LengthConstraint(2, 100, "Votre nom doit contenir au moins 2 caractères.", "Votre nom doit contenir au plus 100 caractères."),
                    new RequiredConstraint()
                ]
            ])
            ->add("email", "input", [
                "label" => [
                    "value" => "Email",
                    "class" => "",
                ],
                "required" => true,
                "attr" => [
                    "type" => "email",
                    "class" => "form-control",
                    "value" => $user->getEmail()
                ],
                "constraints" => [
                    new EmailConstraint(),
                    new LengthConstraint(6, 100, "Votre adresse mail doit contenir au moins 6 caractères.", "Votre adresse mail doit contenir au plus 100 caractères.")
                ]
            ])
            ->add("pwd", "input", [
                "attr" => [
                    "type" => "password",
                    "class" => "form-control",
                    ],
                "label" => [
                    "value" => "Mot de passe",
                    "class" => "",
                ],
                "constraints" => [
                    new PasswordConstraint(),
                    new LengthConstraint(8, 16, "Votre mot de passe doit contenir au moins 8 caractères.", "Votre mot de passe doit contenir au plus 16 caractères."),
                    new RequiredConstraint()
                ]
            ])
            ->add("dateInserted", "input", [
                "label" => [
                    "value" => "Date d'inscription",
                    "class" => ""
                ],
                "required" => true,
                "readonly" => true,
                "attr" => [
                    "type" => "text",
                    "class" => "form-control",
                    "value" => $user->getDateInserted()
                ],
                "constraints" => [
                    new RequiredConstraint()
                ]
            ])
            ->add("annuler", "link", [
                "attr" => [
                    "href" => Router::getRouteByName("admin.user.index")->getUrl(),
                    "class" => "btn btn-default",
                ],
                "text" => "Annuler",
            ])
            ->add("submit", "input", [
                "attr" => [
                    "type" => "submit",
                    "value" => "Mettre à jour",
                    "class" => "btn btn-primary"
                ]
            ]);
    }

    public function configureOptions(): void
    {
        $this
            ->addConfig("class", User::class)
            ->addConfig("attr", [
                "id" => "udpateProfileForm",
                "class" => "admin-form",
                "name" => "udpateProfileForm"
            ])
            ->addConfig("action", Router::getRouteByName("profile.update")->getUrl());
    }
}