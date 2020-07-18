<?php

namespace App\Models;

use App\Core\Model\Model;
use App\Core\Model\ModelInterface;
use App\Core\Routing\Router;

class Horaire extends Model implements ModelInterface
{
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
                "edit"=> Router::getRouteByName('admin.horaire.edit', $horaire->getId()),
                "destroy"=> Router::getRouteByName('admin.horaire.destroy', $horaire->getId())
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
}