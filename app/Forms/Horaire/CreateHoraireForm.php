<?php

namespace App\Forms\Horaire;

use App\Core\Form;
use App\Core\Routing\Router;
use App\Core\Constraints\LengthConstraint;
use App\Core\Constraints\RequiredConstraint;
use App\Models\Horaire;

class CreateHoraireForm extends Form
{
    public function buildForm()
    {   
        $this->setName("createHoraireForm");

        $this->setBuilder()
            ->add("horaire", "input", [
                "label" => [
                    "value" => "Horaire",
                    "class" => "",
                ],
                "attr" => [
                    "type" => "text",
                    "placeholder"=>"Ex: 11h - 12h",
                    "class" => "form-control"
                ],
                "constraints" => [
                    new LengthConstraint(9, 13, "Mauvais format : HHhMM - HHhMM", "Mauvais format : HHhMM - HHhMM"),
                    new RequiredConstraint()
                ]
            ])
            ->add("annuler", "link", [
                "attr" => [
                    "href" => Router::getRouteByName("admin.horaire.index")->getUrl(),
                    "class" => "btn btn-default",
                ],
                "text" => "Annuler",
            ])
            ->add("submit", "input", [
                "attr" => [
                    "type" => "submit",
                    "value" => "Ajouter",
                    "class" => "btn btn-primary"
                ]
            ]);
    }

    public function configureOptions(): void
    {
        $this
            ->addConfig("class", Horaire::class)
            ->addConfig("attr", [
                "id" => "createHoraireForm",
                "class" => "admin-form",
                "name" => "createHoraireForm"
            ])
            ->addConfig("action", Router::getRouteByName("admin.horaire.store")->getUrl());
    }
}