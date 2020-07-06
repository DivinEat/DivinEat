<?php

namespace App\Models;

use App\Core\Model\Model;
use App\Core\Model\ModelInterface;
use App\Core\Routing\Router;
use App\Models\Role;
use App\Managers\RoleManager;

class User extends Model implements ModelInterface
{
    protected $id;
    protected $firstname;
    protected $lastname;
    protected $email;
    protected $pwd;
    protected $status;
    protected $role;
    protected $dateInserted;
    protected $dateUpdated;

    public function __construct(){
        parent::__construct();
    }

    public function initRelation(): array
    {
        return [
            'role' => Role::class
        ];
    }

    public function setId(int $id): self
    {
        $this->id=$id;
        return $this;
    }
    public function setFirstname($firstname)
    {
        $this->firstname=ucwords(strtolower(trim($firstname)));
        return $this;
    }
    public function setLastname($lastname)
    {
        $this->lastname=ucwords(trim($lastname));
        return $this;
    }
    public function setEmail($email)
    {
        $this->email=strtolower(trim($email));
        return $this;
    }
    public function setPwd($pwd)
    {
        $this->pwd = $pwd;
        return $this;
    }
    public function setStatus($status)
    {
        $this->status=$status;
        return $this;
    }
    public function setRole(Role $role): User
    {
        $this->role=$role;
        return $this;
    }
    public function setDateInserted($dateInserted)
    {
        $this->dateInserted=$dateInserted;
        return $this;
    }
    public function setDateUpdated($dateUpdated)
    {
        $this->dateUpdated=$dateUpdated;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    
    public function getFirstname()
    {
        return $this->firstname;
    }
    public function getLastname()
    {
        return $this->lastname;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function getPwd()
    {
        return $this->pwd;
    }
    public function getStatus()
    {
        return $this->status;
    }
    public function getRole(): Role
    {
        return $this->role;
    }
    public function getDateInserted()
    {
        return $this->dateInserted;
    }
    public function getDateUpdated()
    {
        return $this->dateUpdated;
    }

    public function isAdmin(): bool
    {
        return (int)$this->getStatus() === 1;
    }

    public static function getShowUserTable($users){
        $roleManager = new RoleManager();

        $tabUsers = [];
        foreach($users as $user){
            $role = $roleManager->find($user->getRole()->getId());
            
            $tabUsers[] = [
                "id" => $user->getId(),
                "nom" => $user->getFirstname(),
                "prenom" => $user->getLastname(),
                "email" => $user->getEmail(),
                "dateInserted" => $user->getDateInserted(),
                "status" => $user->getStatus(),
                "role" => $role->getLibelle(),
                "edit"=> Router::getRouteByName('admin.user.edit', $user->getId()),
                "destroy"=> Router::getRouteByName('admin.user.destroy', $user->getId())
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
                "Prénom",
                "Email",
                "Date de création",
                "Status",
                "Rang",
                "Actions"
            ],

            "fields"=>[
                "User"=>[]
            ]
        ];

        $tab["fields"]["User"] = $tabUsers;

        return $tab;
    }
}