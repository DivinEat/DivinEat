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
    public function getdateInserted()
    {
        return $this->dateInserted;
    }
    public function getdateUpdated()
    {
        return $this->dateUpdated;
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
                "dateInserted" => $user->getdateInserted(),
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

    public static function getEditUserForm($object, $roles){ 
        $roleTab = [
            "type"=>"select",
            "values"=> [],
            "label"=>"Rôle",
            "class"=>"form-control"
        ];

        foreach($roles as $role){
            $roleTab["values"][] = [
                "value" => $role->getId(),
                "text" => $role->getLibelle(),
                "selected" => ($role->getId() == $object->getRole()->getId())?"selected":""
            ];
        }

        return [
            "config"=>[
                "method"=>"POST", 
                "action"=> Router::getRouteByName('admin.user.update', $object->getId()),
                "class"=>"admin-form",
                "id"=>"formAddUser",
                "submit"=>[
                    "btn-primary"=>"Envoyer"
                ],
                "annuler"=>[
                    "action"=> Router::getRouteByName('admin.user.index'),
                    "class"=>"btn btn-default",
                    "text"=>"Retour"
                ]
            ],
            "fields"=>[
                "id"=>[
                    "type"=>"text",
                    "value"=> $object->getId(),
                    "class"=>"form-control-none"
                ],
                "firstname"=>[
                    "type"=>"text",
                    "value"=> $object->getFirstname(),
                    "label"=>"Prénom",
                    "class"=>"form-control"
                ],
                "lastname"=>[
                    "type"=>"text",
                    "value"=> $object->getLastName(),
                    "label"=>"Nom",
                    "class"=>"form-control"
                ],
                "email"=>[
                    "type"=>"text",
                    "value"=> $object->getEmail(),
                    "label"=>"Email",
                    "class"=>"form-control"
                ],
                "status"=>[
                    "type"=>"select",
                    "values"=> [
                        [
                            "value" => "1",
                            "text" => "Inactif",
                            "selected" => ($object->getStatus() == 1)?"selected":""
                        ],
                        [
                            "value" => "0",
                            "text" => "Actif",
                            "selected" => ($object->getStatus() == 0)?"selected":""
                        ]
                    ],
                    "label"=>"Status",
                    "class"=>"form-control"
                ],
                "role"=> $roleTab,
                "dateInserted"=>[
                    "type"=>"text",
                    "value"=> $object->getdateInserted(),
                    "label"=>"Date d'inscription",
                    "class"=>"form-control",
                    "disabled" => true
                ],
                "dateUpdated"=>[
                    "type"=>"text",
                    "value"=> $object->getdateUpdated(),
                    "label"=>"Dernière mise à jour",
                    "class"=>"form-control",
                    "disabled" => true
                ],
            ]
        ];
    }

    public static function getRegisterForm(){
        return [
            "config"=>[
                "method"=>"POST", 
                "action"=>helpers::getUrl("User", "register"),
                "class"=>"admin-form width-100",
                "id"=>"formRegisterUser",
                "submit"=>[
                    "btn btn-account btn-account-blue margin-top-50"=>"<i class='fa fa-users'></i>S'inscrire"
                ]
            ],

            "fields"=>[
                "firstname"=>[
                        "type"=>"text",
                        "placeholder"=>"&#xf007;  Prénom",
                        "class"=>"form-control form-control-user",
                        "id"=>"",
                        "required"=>true,
                        "min-length"=>2,
                        "max-length"=>50,
                        "errorMsg"=>"Votre prénom doit faire entre 2 et 50 caractères"
                    ],
                "lastname"=>[
                        "type"=>"text",
                        "placeholder"=>"&#xf007;  Nom",
                        "class"=>"form-control form-control-user",
                        "id"=>"",
                        "required"=>true,
                        "min-length"=>2,
                        "max-length"=>100,
                        "errorMsg"=>"Votre nom doit faire entre 2 et 100 caractères"
                    ],
                "email"=>[
                        "type"=>"email",
                        "placeholder"=>"&#xf0e0;  Adresse Email",
                        "class"=>"form-control form-control-user",
                        "id"=>"",
                        "required"=>true,
                        "uniq"=>["table"=>"users","column"=>"email"],
                        "errorMsg"=>"Le format de votre email ne correspond pas"
                    ],
                "pwd"=>[
                        "type"=>"password",
                        "placeholder"=>"&#xf023;  Mot de passe",
                        "class"=>"form-control form-control-user",
                        "id"=>"",
                        "required"=>true,
                        "errorMsg"=>"Votre mot de passe doit faire entre 6 et 20 caractères avec une minuscule et une majuscule"
                    ],
                "pwdConfirm"=>[
                        "type"=>"password",
                        "placeholder"=>"&#xf023;  Confirmation du mot de passe",
                        "class"=>"form-control form-control-user",
                        "id"=>"",
                        "required"=>true,
                        "confirmWith"=>"pwd",
                        "errorMsg"=>"Votre mot de passe de confirmation ne correspond pas"
                    ],
                "captcha"=>[
                        "type"=>"captcha",
                        "class"=>"form-control form-control-user",
                        "id"=>"",
                        "required"=>true,
                        "placeholder"=>"Veuillez saisir les caractères",
                        "errorMsg"=>"Captcha incorrect"
                    ]
            ]
        ];
    }

    public static function getLoginForm(){
        return [
            "config"=>[
                "method"=>"POST", 
                "action"=>helpers::getUrl("User", "login"),
                "class"=>"admin-form width-100",
                "id"=>"formLoginUser",
                "submit"=>[
                    "btn btn-account btn-account-blue margin-top-50"=>"<i class='fa fa-cloud'></i>Connexion"
                ]
            ],

            "fields"=>[
                "email"=>[
                    "type"=>"email",
                    "placeholder"=>"&#xf2be;  Adresse Email",
                    "class"=>"form-control form-control-user",
                    "id"=>"",
                    "required"=>true,
                    "uniq"=>["table"=>"users","column"=>"email"],
                    "errorMsg"=>"Le format de votre email ne correspond pas"
                ],
                "pwd"=>[
                    "type"=>"password",
                    "placeholder"=>"&#xf084;  Mot de passe",
                    "class"=>"form-control form-control-user",
                    "id"=>"",
                    "required"=>true,
                    "errorMsg"=>"Votre mot de passe doit faire entre 6 et 20 caractères avec une minuscule et une majuscule"
                ]
            ]
        ];
    }

    public static function getPwdForm(){
        return [
            "config"=>[
                "method"=>"POST", 
                "action"=>helpers::getUrl("User", "forgotPwd"),
                "class"=>"admin-form width-100",
                "id"=>"formPwdUser",
                "submit"=>[
                    "btn btn-account btn-account-blue margin-top-50"=>"<i class='fa fa-paper-plane'></i>Envoyer la demande"
                ]
            ],

            "fields"=>[
                "email"=>[
                    "type"=>"email",
                    "placeholder"=>"&#xf2be;  Adresse Email",
                    "class"=>"form-control form-control-user",
                    "id"=>"",
                    "required"=>true,
                    "uniq"=>["table"=>"users","column"=>"email"],
                    "errorMsg"=>"Le format de votre email ne correspond pas"
                ]
            ]
        ];
    }
}