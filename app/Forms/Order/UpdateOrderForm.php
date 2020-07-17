<?php

namespace App\Forms\Order;

use App\Core\Form;
use App\Models\Order;
use App\Core\StringValue;
use App\Core\Routing\Router;
use App\Managers\MenuManager;
use App\Managers\HoraireManager;
use App\Managers\MenuOrderManager;
use App\Core\Constraints\EmailConstraint;
use App\Core\Constraints\LengthConstraint;

class UpdateOrderForm extends Form
{
    public function buildForm()
    {
        $this->setName("updateFormOrder");

        $horaireManager = new HoraireManager();
        $horaires = $horaireManager->findAll();

        $menuManager = new MenuManager();
        $menus = $menuManager->findAll();

        $menuOrderManager = new MenuOrderManager();
        $order = $this->model;
        $menuOrders = $menuOrderManager->findBy(["order" => $order->getId()]);
        $order_menus = [];

        try {
            $user_email = $order->getUser()->getEmail();
        } catch (\Throwable $th) {
            $user_email = null;
        }
        
        foreach ($menuOrders as $menuOrder) {
            $order_menus[] = $menuManager->find($menuOrder->getMenu()->getId());
        }

        if ($order->getStatus() == "En cours") {
            $selectedStatus = new StringValue("En cours", "En cours");
        } else {
            $selectedStatus = new StringValue("Terminé", "Terminé");
        }

        $builder = $this->setBuilder()
            ->add("email", "input", [
                "label" => [
                    "value" => "Email",
                    "class" => "",
                ],
                "attr" => [
                    "type" => "email",
                    "placeholder" => "Email",
                    "class" => "form-control",
                    "value" => $user_email
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
            ]);

        $builder->add("menus", "label", [
            "value" => "Menu",
            "class" => ""
        ]);

        $index_menus = 0;
        foreach ($order_menus as $menu) {
            $builder->add("menu".$index_menus, "select", [
                "attr" => [
                    "class" => "form-control"
                ],
                "data" => $menus,
                "selected" => $menu,
                "getter" => "getNom"
            ]);
            $index_menus++;
        }

        $builder->add("surPlace", "select", [
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
            ->add("status", "select", [
                "attr" => [
                    "class" => "form-control"
                ],
                "label" => [
                    "value" => "Statut",
                    "class" => "",
                ],
                "data" => [
                    new StringValue("En cours", "En cours"),
                    new StringValue("Terminé", "Terminé")
                ],
                "getter" => "getString",
                "selected" => $selectedStatus
            ])
            ->add("date", "date", [
                "attr" => [
                    "class" => "form-control"
                ],
                "label" => "Date",
                "name" => "date",
                "value" => (new \DateTime(strtotime($order->getDate())))->format('Y-m-d')
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
                    "value" => "Mettre à jour",
                    "class" => "btn btn-primary"
                ]
        ]);
    }

    public function configureOptions(): void
    {
        $this
            ->addConfig("class", Order::class)
            ->addConfig("attr", [
                "id" => "udpateOrderForm",
                "class" => "admin-form",
                "name" => "udpateOrderForm"
            ])
            ->addConfig("action", Router::getRouteByName("admin.order.update", $this->model->getId())->getUrl());
    }
}