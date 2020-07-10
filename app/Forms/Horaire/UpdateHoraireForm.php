<?php

namespace App\Forms\Horaire;

use App\Core\Form;
use App\Core\Routing\Router;
use App\Core\Constraints\HoraireConstraint;
use App\Core\Constraints\RequiredConstraint;
use App\Models\Horaire;

class UpdateHoraireForm extends Form
{
    public function buildForm()
    {   
        $horaire = $this->model;

        $this->setName("updateHoraireForm");

        $this->setBuilder()
            ->add("id", "input", [
                "attr" => [
                    "type" => "hidden",
                    "value" => $horaire->getId()
                ],
            ])
            ->add("horaire", "input", [
                "label" => [
                    "value" => "Horaire",
                    "class" => "",
                ],
                "attr" => [
                    "type" => "text",
                    "value" => $horaire->getHoraire(),
                    "class" => "form-control"
                ],
                "constraints" => [
                    new HoraireConstraint(),
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
                    "value" => "Mettre à jour",
                    "class" => "btn btn-primary"
                ]
            ]);
    }

    public function configureOptions(): void
    {
        $this
            ->addConfig("class", Horaire::class)
            ->addConfig("attr", [
                "id" => "updateHoraireForm",
                "class" => "admin-form",
                "name" => "updateHoraireForm"
            ])
            ->addConfig("action", Router::getRouteByName("admin.horaire.update", $this->model->getId())->getUrl());
    }
}