<?php

namespace App\Models;

use App\Core\Model\Model;
use App\Core\Model\ModelInterface;
use App\Core\Routing\Router;
use App\Models\Role;
use App\Managers\RoleManager;

class User extends Model implements ModelInterface
{
    protected $firstname;
    protected $lastname;
    protected $email;
    protected $pwd;
    protected $status;
    protected $role;
    protected ?string $token;
    protected ?string $token_password;
    protected ?string $date_token_password;

    public function __construct(){
        parent::__construct();
    }

    public function initRelation(): array
    {
        return [
            'role' => Role::class
        ];
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
        return $this->setCreatedAt($dateInserted);
    }
    public function setDateUpdated($dateUpdated)
    {
        return $this->setUpdatedAt($dateUpdated);
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
        return $this->getCreatedAt();
    }
    public function getDateUpdated()
    {
        return $this->getUpdatedAt();
    }

    public function isAdmin(): bool
    {
        return $this->getRole()->getLibelle() === 'Administrateur';
    }

    public function isModOrAdmin(): bool
    {
        return $this->isAdmin() || $this->getRole()->getLibelle() === 'Moderateur';
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
                "status" => ($user->getStatus() == true) ? "Actif" : "Inactif",
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

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @param string $token
     */
    public function setToken(?string $token): void
    {
        $this->token = $token;
    }

    /**
     * @return string
     */
    public function getTokenPassword(): ?string
    {
        return $this->token_password;
    }

    /**
     * @param string $token_password
     */
    public function setTokenPassword(?string $token_password): void
    {
        $this->token_password = $token_password;
    }

    /**
     * @return string
     */
    public function getDateTokenPassword(): ?string
    {
        return $this->date_token_password;
    }

    /**
     * @param string $date_token_password
     */
    public function setDateTokenPassword(?string $date_token_password): void
    {
        $this->date_token_password = $date_token_password;
    }
}