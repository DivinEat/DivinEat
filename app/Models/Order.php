<?php

namespace App\Models;

use App\Models\Horaire;
use App\Models\Menu;
use App\Core\Model\Model;
use App\Core\Routing\Router;
use App\Core\Model\ModelInterface;
use App\Managers\RoleManager;
use App\Managers\HoraireManager;
use App\Managers\MenuManager;

class Order extends Model implements ModelInterface
{
    protected $id;
    protected $user;
    protected $horaire;
    protected $date;
    protected $prix;

    public function __construct()
    {
        parent::__construct();
    }

    public function initRelation(): array
    {
        return [
            'user' => User::class,
            'horaire' => Horaire::class
        ];
    }
    public static function getShowOrderTable($orders){
        $roleManager = new RoleManager();

        $tabOrders = [];
        foreach($orders as $order){
            
            $tabOrders[] = [
                "id" => $order->getId(),
                "user" => $order->getUser()->getId(),
                "horaire" => $order->getHoraire(),
                "date" => $order->getDate(),
                "prix" => $order->getPrix()
            ];
        }

        $tab = [
            "config"=>[
                "class"=>"admin-table"
            ],

            "colonnes"=>[
                "Id",
                "user id",
                "horaire",
                "date",
                "prix"
            ],

            "fields"=>[
                "Order"=>[]
            ]
        ];

        $tab["fields"]["Order"] = $tabOrders;

        return $tab;
    }

    public static function getAddOrderForm(){
        $horaireManager = new HoraireManager();
        $horaires = $horaireManager->findAll();

        $menuManager = new MenuManager();
        $menus = $menuManager->findAll();

        $menuTab = [
            "type"=>"select",
            "values"=> [],
            "label"=>"Menu",
            "class"=>"form-control"
        ];

        foreach($menus as $menu){
            $menuTab["values"][] = [
                "value" => $menu->getId(),
                "text" => $menu->getNom()
            ];
        }

        return [
            "config"=>[
                "method"=>"POST", 
                "action"=> Router::getRouteByName('admin.order.store'),
                "class"=>"admin-form",
                "id"=>"formAddOrder",
                "submit"=>[
                    "btn-primary"=>"Envoyer"
                ],
                "annuler"=>[
                    "action"=> Router::getRouteByName('admin.order.index'),
                    "class"=>"btn btn-default",
                    "text"=>"Retour"
                ]
            ],

            "fields"=>[
                "email"=>[
                    "type"=>"email",
                    "placeholder"=>"",
                    "label"=>"Email",
                    "class"=>"form-control",
                    "id"=>"",
                    "required"=>true,
                    "errorMsg"=>"Un email doit être renseigné"
                ],
                "horaire"=>[
                    "type"=>"select",
                    "data"=>$horaires,
                    "label"=>"Horaire",
                    "class"=>"form-control",
                    "id"=>"",
                    "required"=>true,
                    "errorMsg"=>"Une horaire doit être sélectionnée"
                ],
                "menu"=>[
                    "type"=>"select",
                    "values"=>$menuTab,
                    "label"=>"Menu",
                    "class"=>"form-control",
                    "id"=>"",
                    "required"=>true,
                    "errorMsg"=>"Au moins un menu doit être sélectionné"
                ]
            ]
        ];
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }
    public function setUser(User $user): Order
    {
        $this->user=$user;
        return $this;
    }
    public function setHoraire(Horaire $horaire): Order
    {
        $this->horaire = $horaire;
        return $this;
    }
    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }
    public function setPrix($prix)
    {
        $this->prix = $prix;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function getUser(): User
    {
        return $this->user;
    }
    public function getHoraire(): Horaire
    {
        return $this->horaire;
    }
    public function getDate()
    {
        return $this->date;
    }
    public function getPrix()
    {
        return $this->prix;
    }
}