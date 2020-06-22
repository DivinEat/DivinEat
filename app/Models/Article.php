<?php

namespace App\Models;

use App\Core\Model\Model;
use App\Core\Model\ModelInterface;
use App\Core\Routing\Router;

class Article extends Model implements ModelInterface
{
    protected $id;
    protected $title;
    protected $content;
    protected $date_inserted;
    protected $date_updated;

    public function __construct(){
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
    public function setTitle($title)
    {
        $this->title=$title;
        return $this;
    }
    public function setContent($content)
    {
        $this->content=$content;
        return $this;
    }
    public function setDate_inserted($date_inserted)
    {
        $this->date_inserted=$date_inserted;
        return $this;
    }
    public function setDate_updated($date_updated)
    {
        $this->date_updated=$date_updated;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function getTitle()
    {
        return $this->title;
    }
    public function getContent()
    {
        return $this->content;
    }
    public function getDate_inserted()
    {
        return $this->date_inserted;
    }
    public function getDate_updated()
    {
        return $this->date_updated;
    }

    public static function getShowArticleTable($articles){
        $tabArticles = [];
        foreach($articles as $article){
            
            $tabArticles[] = [
                "id" => $article->getId(),
                "title" => $article->getTitle(),
                "date_inserted" => $article->getDate_inserted(),
                "date_updated" => $article->getDate_updated(),
                "edit"=> Router::getRouteByName('admin.article.edit', $article->getId()),
                "destroy"=> Router::getRouteByName('admin.article.destroy', $article->getId())
            ];
        }

        $tab = [
            "config"=>[
                "class"=>"admin-table"
            ],

            "colonnes"=>[
                "Catégorie",
                "Id",
                "Title",
                "Posté le",
                "Modifié le",
                "Actions"
            ],

            "fields"=>[
                "Article"=>[]
            ]
        ];

        $tab["fields"]["Article"] = $tabArticles;

        return $tab;
    }
}