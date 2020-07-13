<?php

namespace App\Forms\Menu;

use App\Core\Form;
use App\Core\StringValue;
use App\Core\Routing\Router;
use App\Models\ElementMenu;
use App\Core\Constraints\LengthConstraint;
use App\Core\Constraints\RequiredConstraint;
use App\Core\Constraints\UniqueConstraint;

class CreateElementMenuForm extends Form
{
    public function buildForm()
    {
        $this->setName("createElementMenuForm");
        
        $this->setBuilder()
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
                ],
                "constraints" => [
                    new RequiredConstraint(),
                    new UniqueConstraint("elementMenus.nom", "L'élément de menu existe déjà !")
                ]
            ])
            ->add("description", "input", [
                "label" => [
                    "value" => "Description",
                    "class" => "",
                ],
                "attr" => [
                    "type" => "textArea",
                    "class" => "form-control form-control-textarea"
                ],
                "constraints" => [
                    new RequiredConstraint()
                ]
            ])
            ->add("prix", "input", [
                "label" => [
                    "value" => "Prix",
                    "class" => "",
                ],
                "attr" => [
                    "type" => "number",
                    "class" => "form-control",
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
                    "value" => "Ajouter",
                    "class" => "btn btn-primary"
                ]
            ]);
    }

    public function configureOptions(): void
    {
        $this
            ->addConfig("class", ElementMenu::class)
            ->addConfig("attr", [
                "id" => "createElementMenuForm",
                "class" => "admin-form",
                "name" => "createElementMenuForm"
            ])
            ->addConfig("action", Router::getRouteByName("admin.elementmenu.store")->getUrl());
    }
}