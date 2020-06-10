<?php

namespace App\Models;

use App\Core\Model\Model;
use App\Core\helpers;

class Menu extends Model
{
    protected $id;
    protected $categorie;
    protected $nom;
    protected $description;
    protected $prix;

    public function __construct()
    {
        parent::__construct();
    }

    public function setId($id)
    {
        $this->id=$id;
    }
    public function setCategorie($categorie)
    {
        $this->categorie=strtolower(trim($categorie));
    }
    public function setNom($nom)
    {
        $this->nom=ucwords(strtolower($nom));
    }
    public function setDescription($description)
    {
        $this->nom=ucwords(strtolower($description));
    }
    public function setPrix($prix)
    {
        $this->prix=$prix;
    }

    public static function getAddMenuForm(){
        return [
            "config"=>[
                "method"=>"POST", 
                "action"=>"",
                "class"=>"admin-form",
                "id"=>"formAddMenu",
                "submit"=>[
                    "btn-primary"=>"Envoyer"
                ],
                "annuler"=>[
                    "action"=>"",
                    "class"=>"btn btn-default",
                    "text"=>"Annuler"
                ]
            ],

            "fields"=>[
                "categorie"=>[
                    "type"=>"select",
                    "label"=>"Catégorie",
                    "class"=>"form-control",
                    "id"=>"",
                    "required"=>true,
                    "errorMsg"=>"Un type doit être renseigné",
                    "values"=>[
                        "1"=>"Menu",
                        "2"=>"Entrée",
                        "3"=>"Plat",
                        "4"=>"Dessert",
                        "5"=>"Boisson"
                    ]
                ],
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

    public static function getShowMenuTable(){
        return [
            "config"=>[
                "class"=>"admin-table"
            ],

            "colonnes"=>[
                "Catégorie",
                "Articles en ventes",
                "Description",
                "Prix",
                "Actions"
            ],

            "fields"=>[
                "Boissons"=>[
                    [
                        "name" => "Coca",
                        "description" => "Super bon",
                        "prix" => "1"
                    ],
                    [
                        "name" => "Sprite",
                        "description" => "Super bon",
                        "prix" => "1"
                    ]
                ],
                "Entrées"=>[
                    [
                        "name" => "Huitre",
                        "description" => "Super bon",
                        "prix" => "1"
                    ],
                    [
                        "name" => "Melon",
                        "description" => "Super bon",
                        "prix" => "1"
                    ]
                ],
                "Plats"=>[
                    [
                        "name" => "Bolognaise",
                        "description" => "Super bon",
                        "prix" => "1"
                    ],
                    [
                        "name" => "Steak",
                        "description" => "Super bon",
                        "prix" => "1"
                    ]
                ],
                "Desserts"=>[
                    [
                        "name" => "Tarte",
                        "description" => "Super bon",
                        "prix" => "1"
                    ],
                    [
                        "name" => "Glace",
                        "description" => "Super bon",
                        "prix" => "1"
                    ]
                ]
            ]
        ];
    }
}