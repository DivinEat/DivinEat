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
        $config = $this->model;

        $this->setName("updateConfigurationForm");

        $this->setBuilder()
            ->add("id", "input", [
                "attr" => [
                    "type" => "hidden",
                    "value" => $config->getId()
                ],
            ])
            ->add("libelle", "input", [
                "attr" => [
                    "type" => "hidden",
                    "value" => $config->getLibelle()
                ],
            ])
            ->add("info", "input", [
                "label" => [
                    "value" => ucwords(str_replace("_", " ", $config->getLibelle())),
                    "class" => "",
                ],
                "attr" => [
                    "type" => "text",
                    "value" => $config->getInfo(),
                    "class" => "form-control"
                ],
                "constraints" => [
                    new RequiredConstraint()
                ]
            ])
            ->add("annuler", "link", [
                "attr" => [
                    "href" => Router::getRouteByName("admin.configuration.index")->getUrl(),
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
            ->addConfig("class", Configuration::class)
            ->addConfig("attr", [
                "id" => "updateConfigurationForm",
                "class" => "admin-form",
                "name" => "updateConfigurationForm"
            ])
            ->addConfig("action", Router::getRouteByName("admin.configuration.update", $this->model->getId())->getUrl());
    }
}