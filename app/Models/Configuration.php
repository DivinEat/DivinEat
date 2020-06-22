<?php

namespace App\Models;

use App\Core\Model\Model;
use App\Core\Model\ModelInterface;
use App\Core\Routing\Router;

class Configuration extends Model implements ModelInterface
{
    protected $id;
    protected $libelle;
    protected $info;

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
        $this->id=$id;
        return $this;
    }
    public function setLibelle($libelle)
    {
        $this->libelle=$libelle;
        return $this;
    }
    public function setInfo($info)
    {
        $this->info=$info;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function getLibelle()
    {
        return $this->libelle;
    }
    public function getInfo()
    {
        return $this->info;
    }

    public static function getAddConfigForm($configs){
        $tab = [];
        foreach($configs as $config){
            $tab[$config->getLibelle()] = $config->getInfo();
        }

        return [
            "config"=>[
                "method"=>"POST", 
                "action"=> Router::getRouteByName('admin.configuration.store'),
                "class"=>"admin-form",
                "id"=>"formAddConfig",
                "submit"=>[
                    "btn-primary"=>"Envoyer"
                ]
            ],
            "fields"=>[
                "nom_du_site"=>[
                    "type"=>"text",
                    "label"=>"Nom du site",
                    "value"=>$tab["nom_du_site"],
                    "class"=>"form-control"
                ],
                "email"=>[
                    "type"=>"email",
                    "label"=>"Email du site",
                    "value"=>$tab["email"],
                    "class"=>"form-control"
                ],
                "facebook"=>[
                    "type"=>"text",
                    "label"=>"Facebook",
                    "value"=>$tab["facebook"],
                    "class"=>"form-control"
                ],
                "instagram"=>[
                    "type"=>"text",
                    "label"=>"Instagram",
                    "value"=>$tab["instagram"],
                    "class"=>"form-control"
                ],
                "linkedin"=>[
                    "type"=>"text",
                    "label"=>"Linkedin",
                    "value"=>$tab["linkedin"],
                    "class"=>"form-control"
                ]
            ]
        ];
    }
}