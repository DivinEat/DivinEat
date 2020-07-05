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

    public static function getShowConfigurationTable($configs){
        $tabConfigs = [];
        foreach($configs as $config){
            $tabConfigs[] = [
                "id" => $config->getId(),
                "libelle" => $config->getLibelle(),
                "info" => $config->getInfo(),
                "edit"=> Router::getRouteByName('admin.configuration.edit', $config->getId())
            ];
        }

        $tab = [
            "config"=>[
                "class"=>"admin-table"
            ],

            "colonnes"=>[
                "Catégorie",
                "Id",
                "Libelle",
                "Informations",
                "Actions"
            ],

            "fields"=>[
                "Configuration"=>[]
            ]
        ];

        $tab["fields"]["Configuration"] = $tabConfigs;
        return $tab;
    }
}