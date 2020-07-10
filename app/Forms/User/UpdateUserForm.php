<?php

namespace App\Forms\User;

use App\Core\Form;
use App\Models\User;
use App\Core\StringValue;
use App\Core\Routing\Router;
use App\Managers\RoleManager;
use App\Core\Constraints\EmailConstraint;
use App\Core\Constraints\LengthConstraint;
use App\Core\Constraints\PasswordConstraint;
use App\Core\Constraints\RequiredConstraint;

class UpdateUserForm extends Form
{
    public function buildForm()
    {
        $user = $this->model;

        $this->setName("updateFormUser");

        if ($user->getStatus() == true) {
            $selectedStatus = new StringValue("Actif", true);
        } else {
            $selectedStatus = new StringValue("Inactif", false);
        }

        $roleManager = new RoleManager();
        $roles = $roleManager->findAll();
        $selectedRole = $user->getRole();
        
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
            ->add("status", "select", [
                "attr" => [
                    "class" => "form-control"
                ],
                "label" => [
                    "value" => "Statut",
                    "class" => "",
                ],
                "data" => [
                    new StringValue("Actif", true),
                    new StringValue("Inactif", false)
                ],
                "getter" => "getString",
                "selected" => $selectedStatus,
                "constraints" => [
                    new RequiredConstraint()
                ]
            ])
            ->add("role", "select", [
                "attr" => [
                    "class" => "form-control"
                ],
                "label" => [
                    "value" => "Role",
                    "class" => "",
                ],
                "data" => $roles,
                "getter" => "getLibelle",
                "selected" => $selectedRole,
                "constraints" => [
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
                "id" => "udpateUserForm",
                "class" => "admin-form",
                "name" => "udpateUserForm"
            ])
            ->addConfig("action", Router::getRouteByName("admin.user.update", $this->model->getId())->getUrl());
    }
}