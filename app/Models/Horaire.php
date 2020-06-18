<?php

namespace App\Models;

use App\Core\Model\Model;
use App\Core\Model\ModelInterface;
use App\Core\Routing\Router;

class Horaire extends Model implements ModelInterface
{
    protected $id;
    protected $horaire;

    public function __construct()
    {
        parent::__construct();
    }

    public function initRelation(): array
    {
        return [];
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }
    public function setHoraire($horaire)
    {
        $this->horaire = $horaire;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHoraire()
    {
        return $this->horaire;
    }

    public static function getShowHoraireTable($horaires){
        $tabHoraires = [];
        foreach($horaires as $horaire){
            
            $tabHoraires[] = [
                "id" => $horaire->getId(),
                "horaire" => $horaire->getHoraire(),
                "edit"=> Router::getRouteByName('admin.horaireedit'),
                "destroy"=> Router::getRouteByName('admin.horairedestroy')
            ];
        }

        $tab = [
            "config"=>[
                "class"=>"admin-table"
            ],

            "colonnes"=>[
                "Catégorie",
                "Id",
                "Horaire",
                "Actions"
            ],

            "fields"=>[
                "Horaire"=>[]
            ]
        ];

        $tab["fields"]["Horaire"] = $tabHoraires;

        return $tab;
    }

    public static function getAddHoraireForm(){
        return [
            "config"=>[
                "method"=>"POST", 
                "action"=> Router::getRouteByName('admin.horairestore'),
                "class"=>"admin-form",
                "id"=>"formAddMenu",
                "submit"=>[
                    "btn-primary"=>"Envoyer"
                ],
                "annuler"=>[
                    "action"=> Router::getRouteByName('admin.horaireindex'),
                    "class"=>"btn btn-default",
                    "text"=>"Retour"
                ]
            ],

            "fields"=>[
                "horaire"=>[
                    "type"=>"text",
                    "placeholder"=>"Ex: 11h - 12h",
                    "label"=>"Horaire",
                    "class"=>"form-control",
                ]
            ]
        ];
    }

    public static function getEditHoraireForm($object){ 
        return [
            "config"=>[
                "method"=>"POST", 
                "action"=> Router::getRouteByName('admin.horaireupdate'),
                "class"=>"admin-form",
                "id"=>"formAddMenu",
                "submit"=>[
                    "btn-primary"=>"Envoyer"
                ],
                "annuler"=>[
                    "action"=> Router::getRouteByName('admin.horaireindex'),
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
                "horaire"=>[
                    "type"=>"text",
                    "value"=> $object->getHoraire(),
                    "label"=>"Horaire",
                    "class"=>"form-control"
                ]
            ]
        ];
    }
}