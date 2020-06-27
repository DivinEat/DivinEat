<?php

namespace App\Forms\User;

use App\Core\Form;
use App\Models\User;
use App\Core\StringValue;
use App\Core\Routing\Router;
use App\Managers\RoleManager;
use App\Core\Builder\FormBuilder;
use App\Core\Constraints\LengthConstraint;

class UpdateUserForm extends Form
{
    public function buildForm()
    {
        $user = $this->model;

        $this->setName('updateFormUser');

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
                    'value' => $user->getId()
                ]
            ])
            ->add('firstname', 'input', [
                'label' => [
                    'value' => 'Prénom',
                    'class' => '',
                ],
                'required' => true,
                'attr' => [
                    "type" => "text",
                    'placeholder' => "Prénom",
                    'class' => 'form-control',
                    'value' => $user->getFirstname()
                ],
                'constraints' => [
                    new LengthConstraint(2, 50, 'Votre prénom doit contenir au moins 2 caractères', 'Votre prénom doit contenir au plus 50 caractères')
                ]
            ])
            ->add('lastname', 'input', [
                'label' => [
                    'value' => 'Nom',
                    'class' => '',
                ],
                'required' => true,
                'attr' => [
                    "type" => "text",
                    'class' => 'form-control',
                    'value' => $user->getLastName()
                ],
                'constraints' => [
                    new LengthConstraint(2, 50, 'Votre prénom doit contenir au moins 2 caractères', 'Votre prénom doit contenir au plus 50 caractères')
                ]
            ])
            ->add('email', 'input', [
                'label' => [
                    'value' => 'Email',
                    'class' => '',
                ],
                'required' => true,
                'attr' => [
                    "type" => "email",
                    'class' => 'form-control',
                    'value' => $user->getEmail()
                ],
                'constraints' => [
                    new LengthConstraint(2, 50, 'Votre prénom doit contenir au moins 2 caractères', 'Votre prénom doit contenir au plus 50 caractères')
                ]
            ])
            ->add('pwd', 'input', [
                'attr' => [
                    "type" => "password",
                    'class' => 'form-control',
                    'value' => $user->getPwd()
                    ],
                "label" => [
                    "value" => "Mot de passe",
                    "class" => "",
                ],
                'required' => true,
            ])
            ->add('status', 'select', [
                "attr" => [
                    "class" => "form-control"
                ],
                "label" => [
                    "value" => "Statut",
                    "class" => "",
                ],
                'data' => [
                    new StringValue("Actif", true),
                    new StringValue("Inactif", false)
                ],
                'getter' => 'getString',
                'selected' => $selectedStatus,
            ])
            ->add('role', 'select', [
                "attr" => [
                    "class" => "form-control"
                ],
                "label" => [
                    "value" => "Role",
                    "class" => "",
                ],
                'data' => $roles,
                'getter' => 'getLibelle',
                'selected' => $selectedRole
            ])
            ->add("dateInserted", "input", [
                "label" => [
                    "value" => "Date d'inscription",
                    "class" => ""
                ],
                'required' => true,
                'readonly' => true,
                'attr' => [
                    "type" => "text",
                    'class' => 'form-control',
                    'value' => $user->getDateInserted()
                ]
            ])
            ->add('annuler', 'link', [
                'attr' => [
                    'href' => Router::getRouteByName('admin.user.index')->getUrl(),
                    'class' => 'btn btn-default',
                ],
                'text' => 'Annuler',
            ])
            ->add('submit', 'submit', [
                'text' => 'Mettre à jour',
                'attr' => [
                    'class' => "btn btn-primary"
                ]
            ]);
    }

    public function configureOptions(): void
    {
        $this
            ->addConfig('class', User::class)
            ->addConfig('attr', [
                "id" => "udpateUserForm",
                "class" => "admin-form",
                "name" => "udpateUserForm"
            ])
            ->addConfig("action", Router::getRouteByName('admin.user.update', $this->model->getId())->getUrl());
    }
}