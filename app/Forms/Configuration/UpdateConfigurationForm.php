<?php

namespace App\Forms\Configuration;

use App\Core\Form;
use App\Core\Routing\Router;
use App\Core\Constraints\LengthConstraint;
use App\Core\Constraints\RequiredConstraint;
use App\Core\Constraints\EmailConstraint;
use App\Models\Configuration;

class UpdateConfigurationForm extends Form
{
    public function buildForm()
    {   
        $configs = $this->model;

        $tab = [];
        foreach($configs as $config){
            $tab[$config->getLibelle()] = $config->getInfo();
        }

        $this->setName("updateConfigurationForm");

        $this->setBuilder()
            ->add("nom_du_site", "input", [
                "label" => [
                    "value" => "Nom du site",
                    "class" => "",
                ],
                "attr" => [
                    "type" => "text",
                    "value" => $tab["nom_du_site"],
                    "class" => "form-control"
                ],
                "constraints" => [
                    new LengthConstraint(1, 55),
                    new RequiredConstraint()
                ]
            ])
            ->add("email", "input", [
                "label" => [
                    "value" => "Email du site",
                    "class" => "",
                ],
                "attr" => [
                    "type" => "email",
                    "value" => $tab["email"],
                    "class" => "form-control"
                ],
                "constraints" => [
                    new EmailConstraint(),
                    new RequiredConstraint()
                ]
            ])
            ->add("facebook", "input", [
                "label" => [
                    "value" => "Facebook",
                    "class" => "",
                ],
                "attr" => [
                    "type" => "text",
                    "value" => $tab["facebook"],
                    "class" => "form-control"
                ],
                "constraints" => [
                    new LengthConstraint(1, 155),
                    new RequiredConstraint()
                ]
            ])
            ->add("instagram", "input", [
                "label" => [
                    "value" => "Instagram",
                    "class" => "",
                ],
                "attr" => [
                    "type" => "text",
                    "value" => $tab["instagram"],
                    "class" => "form-control"
                ],
                "constraints" => [
                    new LengthConstraint(1, 155),
                    new RequiredConstraint()
                ]
            ])
            ->add("linkedin", "input", [
                "label" => [
                    "value" => "Linkedin",
                    "class" => "",
                ],
                "attr" => [
                    "type" => "text",
                    "value" => $tab["linkedin"],
                    "class" => "form-control"
                ],
                "constraints" => [
                    new LengthConstraint(1, 155),
                    new RequiredConstraint()
                ]
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
            ->addConfig("class", Configuration::class)
            ->addConfig("attr", [
                "id" => "updateConfigurationForm",
                "class" => "admin-form",
                "name" => "updateConfigurationForm"
            ])
            ->addConfig("action", Router::getRouteByName("admin.configuration.store")->getUrl());
    }
}