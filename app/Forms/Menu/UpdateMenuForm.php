<?php

namespace App\Forms\Menu;

use App\Core\Form;
use App\Core\StringValue;
use App\Core\Routing\Router;
use App\Models\Menu;
use App\Managers\ElementMenuManager;
use App\Core\Constraints\LengthConstraint;
use App\Core\Constraints\RequiredConstraint;
use App\Core\Constraints\UniqueConstraint;

class UpdateMenuForm extends Form
{
    public function buildForm()
    {
        $menu = $this->model;

        $this->setName("updateMenuForm");

        $elementMenuManager = new ElementMenuManager();
        $elementsMenu = $elementMenuManager->findAll();

        $entrees = [];
        $plats = [];
        $desserts = [];
        foreach($elementsMenu as $elementMenu){
            if($elementMenu->getCategorie() == "entree"){
                $entrees[] = $elementMenu;
            } else if($elementMenu->getCategorie() == "plat"){
                $plats[] = $elementMenu;
            } else if($elementMenu->getCategorie() == "dessert"){
                $desserts[] = $elementMenu;
            }
        }

        $selectedEntree = $menu->getEntree();
        $selectedPlat = $menu->getPlat();
        $selectedDessert = $menu->getDessert();
        
        $this->setBuilder()
            ->add("id", "input", [
                "attr" => [
                    "type" => "hidden",
                    "value" => $menu->getId()
                ],
            ])
            ->add("nom", "input", [
                "label" => [
                    "value" => "Nom",
                    "class" => "",
                ],
                "attr" => [
                    "type" => "text",
                    "class" => "form-control",
                    "value" => $menu->getNom()
                ],
                "constraints" => [
                    new RequiredConstraint(),
                    new UniqueConstraint("menus.nom", "Le menu existe déjà !", $menu->getId())
                ]
            ])
            ->add("entrees", "select", [
                "attr" => [
                    "class" => "form-control"
                ],
                "label" => [
                    "value" => "Entrée",
                    "class" => "",
                ],
                "data" => $entrees,
                "getter" => "getNom",
                "selected" => $selectedEntree,
                "constraints" => [
                    new RequiredConstraint()
                ]
            ])
            ->add("plats", "select", [
                "attr" => [
                    "class" => "form-control"
                ],
                "label" => [
                    "value" => "Plat",
                    "class" => "",
                ],
                "data" => $plats,
                "getter" => "getNom",
                "selected" => $selectedPlat,
                "constraints" => [
                    new RequiredConstraint()
                ]
            ])
            ->add("desserts", "select", [
                "attr" => [
                    "class" => "form-control"
                ],
                "label" => [
                    "value" => "Dessert",
                    "class" => "",
                ],
                "data" => $desserts,
                "getter" => "getNom",
                "selected" => $selectedDessert,
                "constraints" => [
                    new RequiredConstraint()
                ]
            ])
            ->add("annuler", "link", [
                "attr" => [
                    "href" => Router::getRouteByName("admin.menu.index")->getUrl(),
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
            ->addConfig("class", Menu::class)
            ->addConfig("attr", [
                "id" => "updateMenuForm",
                "class" => "admin-form",
                "name" => "updateMenuForm"
            ])
            ->addConfig("action", Router::getRouteByName("admin.menu.update", $this->model->getId())->getUrl());
    }
}