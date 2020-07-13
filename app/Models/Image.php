<?php

namespace App\Models;

use App\Core\Model\Model;
use App\Core\Routing\Router;
use App\Core\Model\ModelInterface;

class Image extends Model implements ModelInterface
{
    protected $id;
    protected $nom;
    protected $path;

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
    public function setNom($nom)
    {
        $this->nom=$nom;
        return $this;
    }
    public function setPath($path)
    {
        $this->path= $path;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function getNom()
    {
        return $this->nom;
    }
    public function getPath()
    {
        return $this->path;
    }

    public static function getShowImageTable($images){
        $tabImages = [];
        foreach($images as $image){
            $tabImages[] = [
                "id" => $image->getId(),
                "nom" => $image->getNom(),
                "path" => $image->getPath(),
                "destroy"=> Router::getRouteByName('admin.image.destroy', $image->getId())
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
                "Path",
                "Actions"
            ],

            "fields"=>[
                "Image"=>[]
            ]
        ];

        $tab["fields"]["Image"] = $tabImages;

        return $tab;
    }
}