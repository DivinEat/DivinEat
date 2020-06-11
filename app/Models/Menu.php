<?php

namespace App\Models;

use App\Core\Model\Model;
use App\Core\Routing\Router;
use App\Core\helpers;

class Menu extends Model
{
    protected $id;
    protected $nom;
    protected $entree;
    protected $plat;
    protected $dessert;
    protected $prix;

    public function __construct()
    {
        parent::__construct();
    }

    public function setId($id)
    {
        $this->id=$id;
    }
    public function setNom($nom)
    {
        $this->nom=$nom;
    }
    public function setEntree($entree)
    {
        $this->entree=$entree;
    }
    public function setPlat($plat)
    {
        $this->plat=$plat;
    }
    public function setDessert($dessert)
    {
        $this->dessert=$dessert;
    }
    public function setPrix($prix)
    {
        $this->prix=$prix;
    }

    public function getId()
    {
        return $this->id;
    }
    public function getNom()
    {
        return $this->nom;
    }
    public function getEntree()
    {
        return $this->entree;
    }
    public function getPlat()
    {
        return $this->plat;
    }
    public function getDessert()
    {
        return $this->dessert;
    }
    public function getPrix()
    {
        return $this->prix;
    }

    public static function getAddMenuForm(){
        return [
            "config"=>[
                "method"=>"POST", 
                "action"=> Router::getRouteByName('admin.writeCreate'),
                "class"=>"admin-form",
                "id"=>"formAddMenu",
                "submit"=>[
                    "btn-primary"=>"Envoyer"
                ],
                "annuler"=>[
                    "action"=> Router::getRouteByName('admin.menuindex'),
                    "class"=>"btn btn-default",
                    "text"=>"Retour"
                ]
            ],

            "fields"=>[
                "nom"=>[
                    "type"=>"text",
                    "placeholder"=>"",
                    "label"=>"Nom",
                    "class"=>"form-control",
                    "id"=>"",
                    "required"=>true,
                    "min-length"=>2,
                    "max-length"=>100,
                    "errorMsg"=>"Un nom doit être renseigné"
                ],
                "description"=>[
                    "type"=>"textarea",
                    "label"=>"Description",
                    "class"=>"form-control form-control-textarea",
                    "id"=>"",
                    "required"=>true,
                    "errorMsg"=>"Une description doit être renseignée"
                ],
                "prix"=>[
                    "type"=>"number",
                    "label"=>"Prix",
                    "class"=>"form-control",
                    "id"=>"",
                    "required"=>true,
                    "errorMsg"=>"Un prix doit être renseigné"
                ]
            ]
        ];
    }

    public static function getShowMenuTable($menus){
        $tabMenus = [];
        foreach($menus as $menu){
            $tabMenus[] = [
                "id" => $menu->getId(),
                "nom" => $menu->getNom(),
                "entree" => $menu->getEntree(),
                "plat" => $menu->getPlat(),
                "dessert" => $menu->getDessert(),
                "prix" => $menu->getPrix()
            ];
        }

        $tab = [
            "config"=>[
                "class"=>"admin-table",
                "edit"=>"edit",
                "cancel"=>"cancel"
            ],

            "colonnes"=>[
                "Catégorie",
                "Id",
                "Nom",
                "Entrée",
                "Plat",
                "Dessert",
                "Prix",
                "Actions"
            ],

            "fields"=>[
                "Menu"=>[]
            ]
        ];

        $tab["fields"]["Menu"] = $tabMenus;

        return $tab;
    }

    public static function getShowElementMenuTable($elementMenus){
        $tabElementMenus = [
            "Entrée" => [],
            "Plat" => [],
            "Dessert" => [],
            "Boisson" => []
        ];

        foreach($elementMenus as $elementMenu){
            switch($elementMenu->getCategorie()){
                case "entree":
                    $tabElementMenus["Entrée"][] = [
                        "id" => $elementMenu->getId(),
                        "nom" => $elementMenu->getNom(),
                        "description" => $elementMenu->getDescription(),
                        "prix" => $elementMenu->getPrix()
                    ];
                    break;
                case "plat":
                    $tabElementMenus["Plat"][] = [
                        "id" => $elementMenu->getId(),
                        "nom" => $elementMenu->getNom(),
                        "description" => $elementMenu->getDescription(),
                        "prix" => $elementMenu->getPrix()
                    ];
                    break;
                case "dessert":
                    $tabElementMenus["Dessert"][] = [
                        "id" => $elementMenu->getId(),
                        "nom" => $elementMenu->getNom(),
                        "description" => $elementMenu->getDescription(),
                        "prix" => $elementMenu->getPrix()
                    ];
                    break;
                case "boisson":
                    $tabElementMenus["Boisson"][] = [
                        "id" => $elementMenu->getId(),
                        "nom" => $elementMenu->getNom(),
                        "description" => $elementMenu->getDescription(),
                        "prix" => $elementMenu->getPrix()
                    ];
                    break;
            }
        }

        $tab = [
            "config"=>[
                "class"=>"admin-table",
                "edit"=>"edit",
                "cancel"=>"cancel"
            ],

            "colonnes"=>[
                "Catégorie",
                "Id",
                "Nom",
                "Description",
                "Prix",
                "Actions"
            ],

            "fields"=>[]
        ];

        $tab["fields"] = $tabElementMenus;

        return $tab;
    }
}