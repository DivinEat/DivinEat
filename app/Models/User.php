<?php

namespace App\Models;

use App\Core\Model\Model;
use App\Core\Routing\Router;

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
    public function getDate_inserted()
    {
        return $this->date_inserted;
    }
    public function getDate_updated()
    {
        return $this->date_updated;
    }

    public static function getLibelleStatus($status){
        switch($status){
            case 0:
                $libelleStatus = "Membre";
                break;
            case 1:
                $libelleStatus = "Administrateur";
                break;
        }

        return $libelleStatus;
    }

    public static function getShowUserTable($users){
        $tabUsers = [];
        foreach($users as $user){
            $tabUsers[] = [
                "id" => $user->getId(),
                "nom" => $user->getFirstname(),
                "prenom" => $user->getLastname(),
                "email" => $user->getEmail(),
                "date_inserted" => $user->getDate_inserted(),
                "status" => User::getLibelleStatus($user->getStatus()),
                "edit"=> Router::getRouteByName('admin.useredit'),
                "destroy"=> Router::getRouteByName('admin.userdestroy')
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

    public static function getEditUserForm($object){
        return [
            "config"=>[
                "method"=>"POST", 
                "action"=> Router::getRouteByName('admin.userdupdate'),
                "class"=>"admin-form",
                "id"=>"formAddMenu",
                "submit"=>[
                    "btn-primary"=>"Envoyer"
                ],
                "annuler"=>[
                    "action"=> Router::getRouteByName('admin.userindex'),
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
                            "text" => "Admin",
                            "selected" => ""
                        ],
                        [
                            "value" => "0",
                            "text" => "Membre",
                            "selected" => "selected"
                        ]
                    ],
                    "label"=>"Rang",
                    "class"=>"form-control"
                ],
                "date_inserted"=>[
                    "type"=>"text",
                    "value"=> $object->getDate_inserted(),
                    "label"=>"Date d'inscription",
                    "class"=>"form-control",
                    "disabled" => true
                ],
                "date_updated"=>[
                    "type"=>"text",
                    "value"=> $object->getDate_updated(),
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