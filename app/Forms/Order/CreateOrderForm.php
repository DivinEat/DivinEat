<?php

namespace App\Forms\Order;

use App\Core\Form;
use App\Models\User;
use App\Core\StringValue;
use App\Core\Routing\Router;
use App\Managers\RoleManager;
use App\Core\Constraints\EmailConstraint;
use App\Core\Constraints\LengthConstraint;
use App\Managers\HoraireManager;
use App\Managers\MenuManager;

class CreateOrderForm extends Form
{
    public function buildForm()
    {

        $horaireManager = new HoraireManager();
        $horaires = $horaireManager->findAll();

        $menuManager = new MenuManager();
        $menus = $menuManager->findAll();

        $this->setName("createFormOrder");
        
        $this->setBuilder()
            ->add("email", "input", [
                "label" => [
                    "value" => "Email",
                    "class" => "",
                ],
                "attr" => [
                    "type" => "email",
                    "placeholder" => "Email",
                    "class" => "form-control",
                    "value" => ""
                ],
                "constraints" => [
                    new EmailConstraint(),
                    new LengthConstraint(6, 100, "Votre adresse mail doit contenir au moins 6 caractères.", "Votre adresse mail doit contenir au plus 100 caractères.")
                ]
            ])
            ->add("horaire", "select", [
                "attr" => [
                    "class" => "form-control"
                ],
                "label" => [
                    "value" => "Horaires",
                    "class" => "",
                ],
                "data" => $horaires,
                "getter" => "getHoraire",
            ])
            ->add("menu", "select", [
                "attr" => [
                    "class" => "form-control"
                ],
                "label" => [
                    "value" => "Menu",
                    "class" => "",
                ],
                "data" => $menus,
                "getter" => "getNom",
            ])
            ->add("surPlace", "select", [
                "attr" => [
                    "class" => "form-control"
                ],
                "label" => [
                    "value" => "Sur place",
                    "class" => "",
                ],
                "data" => [
                    new StringValue("Oui", 1),
                    new StringValue("Non", 0)
                ],
                "getter" => "getString"])
            ->add("annuler", "link", [
                "attr" => [
                    "href" => Router::getRouteByName("admin.order.index")->getUrl(),
                    "class" => "btn btn-default",
                ],
                "text" => "Annuler",
            ])
            ->add("submit", "input", [
                "attr" => [
                    "type" => "submit",
                    "value" => "Créer",
                    "class" => "btn btn-primary"
                ]
            ])
            ;
    }

    public function configureOptions(): void
    {
        $this
            ->addConfig("class", Order::class)
            ->addConfig("attr", [
                "id" => "createOrderForm",
                "class" => "admin-form",
                "name" => "createOrderForm"
            ])
            ->addConfig("action", Router::getRouteByName("admin.order.store")->getUrl());
    }
}