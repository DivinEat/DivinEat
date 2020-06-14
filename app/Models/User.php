<?php

namespace App\Models;

use App\Core\Model\Model;
use App\Core\helpers;

class User extends Model
{
    protected $id;
    protected $firstname;
    protected $lastname;
    protected $email;
    protected $pwd;
    protected $status;
    protected $date_inserted;
    protected $date_updated;

    public function __construct(){
        parent::__construct();
    }

    public function initRelation(){
        return [];
    }

    public function setId($id)
    {
        $this->id=$id;
    }
    public function setFirstname($firstname)
    {
        $this->firstname=ucwords(strtolower(trim($firstname)));
    }
    public function setLastname($lastname)
    {
        $this->lastname=strtoupper(trim($lastname));
    }
    public function setEmail($email)
    {
        $this->email=strtolower(trim($email));
    }
    public function setPwd($pwd)
    {
        $this->pwd=$pwd;
    }
    public function setStatus($status)
    {
        $this->status=$status;
    }
    public function setDate_inserted($date_inserted)
    {
        $this->date_inserted=$date_inserted;
    }
    public function setDate_updated($date_updated)
    {
        $this->date_updated=$date_updated;
    }

    public function getId()
    {
        return $this->id;
    }

    public static function getShowUserTable($users){
        $tabMenus = [];
        foreach($menus as $menu){
            $tabMenus[] = [
                "id" => $menu->getId(),
                "nom" => $menu->getNom(),
                "entree" => $menu->getEntree(),
                "plat" => $menu->getPlat(),
                "dessert" => $menu->getDessert(),
                "prix" => $menu->getPrix(),
                "edit"=> Router::getRouteByName('admin.menuedit'),
                "destroy"=> Router::getRouteByName('admin.menudestroy')
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