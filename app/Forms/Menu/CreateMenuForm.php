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

class CreateMenuForm extends Form
{
    public function buildForm()
    {
        $this->setName("createMenuForm");

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
        
        $this->setBuilder()
            ->add("nom", "input", [
                "label" => [
                    "value" => "Nom",
                    "class" => "",
                ],
                "attr" => [
                    "type" => "text",
                    "class" => "form-control",
                ],
                "constraints" => [
                    new RequiredConstraint(),
                    new UniqueConstraint("menus.nom", "Le menu existe déjà !")
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
                    "value" => "Ajouter",
                    "class" => "btn btn-primary"
                ]
            ]);
    }

    public function configureOptions(): void
    {
        $this
            ->addConfig("class", Menu::class)
            ->addConfig("attr", [
                "id" => "createMenuForm",
                "class" => "admin-form",
                "name" => "createMenuForm"
            ])
            ->addConfig("action", Router::getRouteByName("admin.menu.store")->getUrl());
    }
}