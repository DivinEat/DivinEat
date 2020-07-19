<?php

namespace App\Forms\Menu;

use App\Core\Form;
use App\Core\StringValue;
use App\Core\Routing\Router;
use App\Models\ElementMenu;
use App\Core\Constraints\LengthConstraint;
use App\Core\Constraints\RequiredConstraint;
use App\Core\Constraints\UniqueConstraint;

class UpdateElementMenuForm extends Form
{
    public function buildForm()
    {
        $elementMenu = $this->model;

        if ($elementMenu->getCategorie() == "entree") {
            $selectedCategorie = new StringValue("Entrée", "2");
        } else if($elementMenu->getCategorie() == "plat") {
            $selectedCategorie = new StringValue("Plat", "3");
        } else if($elementMenu->getCategorie() == "dessert") {
            $selectedCategorie = new StringValue("Dessert", "4");
        } else if($elementMenu->getCategorie() == "boisson") {
            $selectedCategorie = new StringValue("Boisson", "5");
        }

        $this->setName("updateMenuForm");
        
        $this->setBuilder()
            ->add("id", "input", [
                "attr" => [
                    "type" => "hidden",
                    "value" => $elementMenu->getId()
                ],
            ])
            ->add("categorie", "select", [
                "attr" => [
                    "class" => "form-control"
                ],
                "label" => [
                    "value" => "Catégories",
                    "class" => "",
                ],
                "data" => [
                    new StringValue("Entrée", "2"),
                    new StringValue("Plat", "3"),
                    new StringValue("Dessert", "4"),
                    new StringValue("Boisson", "5"),
                ],
                "getter" => "getString",
                "selected" => $selectedCategorie,
                "constraints" => [
                    new RequiredConstraint()
                ]
            ])
            ->add("nom", "input", [
                "label" => [
                    "value" => "Nom",
                    "class" => "",
                ],
                "attr" => [
                    "type" => "text",
                    "class" => "form-control",
                    "value" => $elementMenu->getNom()
                ],
                "constraints" => [
                    new RequiredConstraint(),
                    new UniqueConstraint("elementMenus.nom", "L'élément de menu existe déjà !", $elementMenu->getId())
                ]
            ])
            ->add("description", "textArea", [
                "label" => [
                    "value" => "Description",
                    "class" => "",
                ],
                "attr" => [
                    "class" => "form-control form-control-textarea",
                ],
                "constraints" => [
                    new RequiredConstraint()
                ],
                "text" => $elementMenu->getDescription()
            ])
            ->add("prix", "input", [
                "label" => [
                    "value" => "Prix",
                    "class" => "",
                ],
                "attr" => [
                    "type" => "number",
                    "class" => "form-control",
                    "value" => $elementMenu->getPrix()
                ],
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
            ->addConfig("class", ElementMenu::class)
            ->addConfig("attr", [
                "id" => "updateMenuForm",
                "class" => "admin-form",
                "name" => "updateMenuForm"
            ])
            ->addConfig("action", Router::getRouteByName("admin.elementmenu.update", [$this->model->getId(), 2])->getUrl());
    }
}