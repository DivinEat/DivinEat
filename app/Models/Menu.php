<?php

namespace App\Models;

use App\Core\Model\Model;
use App\Core\Model\ModelInterface;
use App\Core\Routing\Router;
use App\Models\ElementMenu;
use App\Managers\ElementMenuManager;

class Menu extends Model implements ModelInterface
{
    protected $nom;
    protected $entree;
    protected $plat;
    protected $dessert;
    protected $prix;

    public function __construct()
    {
        parent::__construct();
    }

    public function initRelation(): array
    {
        return [
            'entree' => ElementMenu::class,
            'plat' => ElementMenu::class,
            'dessert' => ElementMenu::class,
        ];
    }

    public function setNom($nom)
    {
        $this->nom=$nom;
        return $this;
    }
    public function setEntree(ElementMenu $entree): Menu
    {
        $this->entree=$entree;
        return $this;
    }
    public function setPlat(ElementMenu $plat): Menu
    {
        $this->plat=$plat;
        return $this;
    }
    public function setDessert(ElementMenu $dessert): Menu
    {
        $this->dessert=$dessert;
        return $this;
    }
    public function setPrix($prix)
    {
        $this->prix=$prix;
        return $this;
    }
    public function getNom()
    {
        return $this->nom;
    }
    public function getEntree(): ElementMenu
    {
        return $this->entree;
    }
    public function getPlat(): ElementMenu
    {
        return $this->plat;
    }
    public function getDessert(): ElementMenu
    {
        return $this->dessert;
    }
    public function getPrix()
    {
        return $this->prix;
    }

    public static function getShowMenuTable($menus){
        $elementMenuManager = new ElementMenuManager();

        $tabMenus = [];
        foreach($menus as $menu){
            $entree = $elementMenuManager->find($menu->getEntree()->getId());
            $plat = $elementMenuManager->find($menu->getPlat()->getId());
            $dessert = $elementMenuManager->find($menu->getDessert()->getId());
            
            $tabMenus[] = [
                "id" => $menu->getId(),
                "nom" => $menu->getNom(),
                "entree" => $entree->getNom(),
                "plat" => $plat->getNom(),
                "dessert" => $dessert->getNom(),
                "prix" => $menu->getPrix(),
                "edit"=> Router::getRouteByName('admin.menu.edit', $menu->getId()),
                "destroy"=> Router::getRouteByName('admin.menu.destroy', $menu->getId())
            ];
        }

        $tab = [
            "config"=>[
                "class"=>"admin-table"
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
                        "prix" => $elementMenu->getPrix(),
                        "edit"=> Router::getRouteByName('admin.elementmenu.edit', [$elementMenu->getId(), 2]),
                        "destroy"=> Router::getRouteByName('admin.elementmenu.destroy', [$elementMenu->getId(), 2])
                    ];
                    break;
                case "plat":
                    $tabElementMenus["Plat"][] = [
                        "id" => $elementMenu->getId(),
                        "nom" => $elementMenu->getNom(),
                        "description" => $elementMenu->getDescription(),
                        "prix" => $elementMenu->getPrix(),
                        "edit"=> Router::getRouteByName('admin.elementmenu.edit', [$elementMenu->getId(), 3]),
                        "destroy"=> Router::getRouteByName('admin.elementmenu.destroy', [$elementMenu->getId(), 3])
                    ];
                    break;
                case "dessert":
                    $tabElementMenus["Dessert"][] = [
                        "id" => $elementMenu->getId(),
                        "nom" => $elementMenu->getNom(),
                        "description" => $elementMenu->getDescription(),
                        "prix" => $elementMenu->getPrix(),
                        "edit"=> Router::getRouteByName('admin.elementmenu.edit', [$elementMenu->getId(), 4]),
                        "destroy"=> Router::getRouteByName('admin.elementmenu.destroy', [$elementMenu->getId(), 4])
                    ];
                    break;
                case "boisson":
                    $tabElementMenus["Boisson"][] = [
                        "id" => $elementMenu->getId(),
                        "nom" => $elementMenu->getNom(),
                        "description" => $elementMenu->getDescription(),
                        "prix" => $elementMenu->getPrix(),
                        "edit"=> Router::getRouteByName('admin.elementmenu.edit', [$elementMenu->getId(), 5]),
                        "destroy"=> Router::getRouteByName('admin.elementmenu.destroy', [$elementMenu->getId(), 5])
                    ];
                    break;
            }
        }

        $tab = [
            "config"=>[
                "class"=>"admin-table"
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