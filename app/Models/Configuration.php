<?php

namespace App\Models;

use App\Core\Model\Model;
use App\Core\Model\ModelInterface;
use App\Core\Routing\Router;
use App\Models\ElementMenu;

class Configuration extends Model implements ModelInterface
{
    protected $id;
    protected $libelle;
    protected $option;

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
    public function setOption($option)
    {
        $this->option=$option;
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
    public function getOption()
    {
        return $this->option;
    }

    public static function getAddConfigForm($configs){
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
                    "class"=>"form-control"
                ],
                "email"=>[
                    "type"=>"email",
                    "label"=>"Email du site",
                    "class"=>"form-control"
                ],
                "facebook"=>[
                    "type"=>"text",
                    "label"=>"Facebook",
                    "class"=>"form-control"
                ],
                "instagram"=>[
                    "type"=>"text",
                    "label"=>"Instagram",
                    "class"=>"form-control"
                ],
                "linkedin"=>[
                    "type"=>"text",
                    "label"=>"Linkedin",
                    "class"=>"form-control"
                ]
            ]
        ];
    }
}