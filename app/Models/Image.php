<?php

namespace App\Models;

use App\Core\Model\Model;
use App\Core\Routing\Router;
use App\Core\Model\ModelInterface;

class Image extends Model implements ModelInterface
{
    protected $id;
    protected $name;
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
    public function setName($name)
    {
        $this->name=$name;
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
    public function getName()
    {
        return $this->name;
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
                "thumbnail" => "<img src='" . url("img/uploadedImages/" . $image->getPath()) . "' alt='Forest' class='thumbnail'>",
                "name" => $image->getName(),
                "destroy" => Router::getRouteByName('admin.image.destroy', $image->getId())
            ];
        }

        $tab = [
            "config"=>[
                "class"=>"admin-table"
            ],

            "colonnes"=>[
                "Catégorie",
                "Id",
                "Thumbnail",
                "Nom",
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