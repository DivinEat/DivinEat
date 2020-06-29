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
                    "placeholder" => "Prénom",
                    "class" => "form-control",
                    "value" => $user->getFirstname()
                ],
                "constraints" => [
                    new LengthConstraint(2, 50, "Votre prénom doit contenir au moins 2 caractères.", "Votre prénom doit contenir au plus 50 caractères.")
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
                    new LengthConstraint(2, 100, "Votre prénom doit contenir au moins 2 caractères.", "Votre nom doit contenir au plus 100 caractères.")
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
                    new LengthConstraint(6, 100, "Votre prénom doit contenir au moins 6 caractères.", "Votre nom doit contenir au plus 100 caractères.")
                ]
            ])
            ->add("pwd", "input", [
                "attr" => [
                    "type" => "password",
                    "class" => "form-control",
                    "value" => $user->getPwd()
                    ],
                "label" => [
                    "value" => "Mot de passe",
                    "class" => "",
                ],
                "constraints" => [
                    new PasswordConstraint(),
                    new LengthConstraint(8, 16, "Votre mot de passe doit contenir au moins 8 caractères.", "Votre nom doit contenir au plus 16 caractères.")
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
                "selected" => $selectedRole
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
            ])
            // ->add("textarea", "textArea", [
            //     "label" => [
            //         "value" => "Text Area",
            //         "class" => ""
            //     ],
            //     "text" => "Contenu du textArea",
            //     "attr" => [
            //         "class" => "form-control form-control-textarea",
            //         "rows" => "5",
            //         "cols" => "20"
            //     ]
            // ])
            ;
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