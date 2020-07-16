<?php

namespace App\Forms\Order;

use App\Core\Auth;
use App\Core\Form;
use App\Models\User;
use App\Models\Order;
use App\Core\StringValue;
use App\Core\Routing\Router;
use App\Managers\MenuManager;
use App\Managers\RoleManager;
use App\Managers\HoraireManager;
use App\Core\Constraints\EmailConstraint;
use App\Core\Constraints\LengthConstraint;

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
            ->add("date", "date", [
                "attr" => [
                    "class" => "form-control"
                ],
                "label" => "Date",
                "name" => "date",
                "value" => date("Y-m-d", strtotime("+1 day", time()))
            ])
            ->add("annuler", "link", [
                "attr" => [
                    "href" => Auth::getUser()->isAdmin() ? Router::getRouteByName("admin.order.index")->getUrl() : Router::getRouteByName("order.index")->getUrl(),
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
            ]);
        
        if(Auth::getUser()->isAdmin()) {
            $this->addConfig("action", Router::getRouteByName("admin.order.store")->getUrl());
        } else {
            $this->addConfig("action", Router::getRouteByName("order.store")->getUrl());
        }
            
    }
}