<?php

namespace App\Forms\Order;

use App\Core\Form;
use App\Models\User;
use App\Core\StringValue;
use App\Core\Routing\Router;
use App\Managers\RoleManager;
use App\Core\Constraints\EmailConstraint;
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

        $this->setName("updateFormUser");
        
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
                ]
            ])
            ->add("horaires", "select", [
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
            ->add("menus", "select", [
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
            ->addConfig("action", Router::getRouteByName("admin.order.create")->getUrl());
    }
}