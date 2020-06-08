<?php
namespace App\models;
use App\core\helpers;
use App\core\Model;
use JSONSerializable;

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

    public static function getRegisterForm(){
        return [
                    "config"=>[
                        "method"=>"POST", 
                        "action"=>helpers::getUrl("user", "register"),
                        "class"=>"user",
                        "id"=>"formRegisterUser",
                        "submit"=>"S'inscrire"
                        ],

                    "fields"=>[
                        "firstname"=>[
                                "type"=>"text",
                                "placeholder"=>"Votre prénom",
                                "class"=>"form-control form-control-user",
                                "id"=>"",
                                "required"=>true,
                                "min-length"=>2,
                                "max-length"=>50,
                                "errorMsg"=>"Votre prénom doit faire entre 2 et 50 caractères"
                            ],
                        "lastname"=>[
                                "type"=>"text",
                                "placeholder"=>"Votre nom",
                                "class"=>"form-control form-control-user",
                                "id"=>"",
                                "required"=>true,
                                "min-length"=>2,
                                "max-length"=>100,
                                "errorMsg"=>"Votre nom doit faire entre 2 et 100 caractères"
                            ],
                        "email"=>[
                                "type"=>"email",
                                "placeholder"=>"Votre email",
                                "class"=>"form-control form-control-user",
                                "id"=>"",
                                "required"=>true,
                                "uniq"=>["table"=>"users","column"=>"email"],
                                "errorMsg"=>"Le format de votre email ne correspond pas"
                            ],
                        "pwd"=>[
                                "type"=>"password",
                                "placeholder"=>"Votre mot de passe",
                                "class"=>"form-control form-control-user",
                                "id"=>"",
                                "required"=>true
                            ],
                        "pwdConfirm"=>[
                                "type"=>"password",
                                "placeholder"=>"Confirmation",
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

                ];
    }
}