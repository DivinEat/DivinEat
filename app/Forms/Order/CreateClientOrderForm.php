<?php

namespace App\Forms\Order;

use App\Core\Form;
use App\Models\Order;
use App\Core\StringValue;
use App\Core\Routing\Router;
use App\Managers\MenuManager;
use App\Managers\HoraireManager;
use App\Core\Constraints\EmailConstraint;
use App\Core\Constraints\RequiredConstraint;

class CreateClientOrderForm extends Form
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
                    "class" => "form-control form-control-user",
                    "value" => ""
                ],
                "constraints" => [
                    new EmailConstraint(),
                    new RequiredConstraint()
                ]
            ])
            ->add("horaire", "select", [
                "attr" => [
                    "class" => "form-control form-control-user"
                ],
                "label" => [
                    "value" => "Horaires",
                    "class" => "",
                ],
                "data" => $horaires,
                "getter" => "getHoraire",
                "constraints" => [
                    new RequiredConstraint()
                ]
            ])
            ->add("menu", "select", [
                "attr" => [
                    "class" => "form-control form-control-user"
                ],
                "label" => [
                    "value" => "Menu",
                    "class" => "",
                ],
                "data" => $menus,
                "getter" => "getNom",
                "constraints" => [
                    new RequiredConstraint()
                ]
            ])
            ->add("surPlace", "select", [
                "attr" => [
                    "class" => "form-control form-control-user"
                ],
                "label" => [
                    "value" => "Sur place",
                    "class" => "",
                ],
                "data" => [
                    new StringValue("Oui", 1),
                    new StringValue("Non", 0)
                ],
                "getter" => "getString",
                "constraints" => [
                    new RequiredConstraint()
                ]
                ])
            ->add("date", "date", [
                "attr" => [
                    "class" => "form-control form-control-user"
                ],
                "label" => "Date",
                "name" => "date",
                "value" => date("Y-m-d", strtotime("+1 day", time())),
                "constraints" => [
                    new RequiredConstraint()
                ]
            ])
            ->add("submit", "input", [
                "attr" => [
                    "type" => "submit",
                    "value" => "Créer",
                    "class" => "btn btn-account btn-account-blue margin-top-50"
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
                "class" => "admin-form width-100",
                "name" => "createOrderForm"
            ])
            ->addConfig("action", Router::getRouteByName("order.store")->getUrl());
    }
}