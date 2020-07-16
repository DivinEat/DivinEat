<?php

namespace App\Models;

use App\Models\Menu;
use App\Models\User;
use App\Models\Horaire;
use App\Core\Model\Model;
use App\Core\Routing\Router;
use App\Managers\MenuManager;
use App\Managers\RoleManager;
use App\Managers\UserManager;
use App\Managers\HoraireManager;
use App\Core\Model\ModelInterface;
use App\Managers\MenuOrderManager;

class Order extends Model implements ModelInterface
{
    protected $id;
    protected $user;
    protected $horaire;
    protected $date;
    protected $prix;
    protected $status;
    protected $surPlace;

    public function __construct()
    {
        parent::__construct();
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
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }
    public function setSurPlace($surPlace)
    {
        $this->surPlace = $surPlace;
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
    public function getStatus()
    {
        return $this->status;
    }
    public function getSurPlace()
    {
        return $this->surPlace;
    }

    public function initRelation(): array
    {
        return [
            'user' => User::class,
            'horaire' => Horaire::class
        ];
    }
    public static function getShowOrderTable($orders){
        $menuOrderManager = new MenuOrderManager();
        $menuManager = new MenuManager();

        $tabOrders = [];
        foreach($orders as $order){
            $menuOrders = $menuOrderManager->findBy(["order" => $order->getId()]);
            $menus = [];
            
            foreach ($menuOrders as $menuOrder) {
                $menus[] = $menuManager->find($menuOrder->getMenu()->getId())->getNom();
            }
            $tabOrders[] = [
                "id" => $order->getId(),
                "user" =>  $order->getUser()->getEmail(),
                "horaire" => $order->getHoraire()->getHoraire(),
                "date" => $order->getDate(),
                "menus" => implode(", ", $menus),
                "prix" => $order->getPrix() . "€",
                "status" => $order->getStatus(),
                "surPlace" => $order->getSurPlace() == 1 ? "Oui" : "Non",
                "edit"=> Router::getRouteByName('admin.order.edit', $order->getId()),
                "destroy"=> Router::getRouteByName('admin.order.destroy', $order->getId())
            ];
        }

        $tab = [
            "config"=>[
                "class"=>"admin-table"
            ],

            "colonnes"=>[
                "",
                "Id",
                "Utilisateur",
                "Horaire",
                "Date",
                "Menus",
                "Prix",
                "Status",
                "Sur place",
                "Actions"
            ],

            "fields"=>[
                "Order"=>[]
            ]
        ];

        $tab["fields"]["Order"] = $tabOrders;
        return $tab;
    }

    public static function getClientShowOrderTable($orders){
        $menuOrderManager = new MenuOrderManager();
        $menuManager = new MenuManager();

        $tabOrders = [];
        foreach($orders as $order){
            $menuOrders = $menuOrderManager->findBy(["order" => $order->getId()]);
            $menus = [];
            
            foreach ($menuOrders as $menuOrder) {
                $menus[] = $menuManager->find($menuOrder->getMenu()->getId())->getNom();
            }
            $tabOrders[] = [
                "user" =>  $order->getUser()->getEmail(),
                "horaire" => $order->getHoraire()->getHoraire(),
                "date" => $order->getDate(),
                "menus" => implode(", ", $menus),
                "prix" => $order->getPrix() . "€",
                "status" => $order->getStatus(),
                "surPlace" => $order->getSurPlace() == 1 ? "Oui" : "Non"
            ];
        }

        $tab = [
            "config"=>[
                "class"=>"admin-table"
            ],

            "colonnes"=>[
                "",
                "Utilisateur",
                "Horaire",
                "Date",
                "Menus",
                "Prix",
                "Status",
                "Sur place"
            ],

            "fields"=>[
                "Order"=>[]
            ]
        ];

        $tab["fields"]["Order"] = $tabOrders;
        return $tab;
    }
}