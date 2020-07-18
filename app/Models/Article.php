<?php

namespace App\Models;

use App\Core\Model\Model;
use App\Core\Model\ModelInterface;
use App\Core\Routing\Router;
use App\Models\User;
use App\Managers\UserManager;

class Article extends Model implements ModelInterface
{
    protected $title;
    protected $content;
    protected $date_inserted;
    protected $date_updated;
    protected $slug;
    protected $author;
    protected $publish;

    public function __construct(){
        parent::__construct();
    }

    public function initRelation(): array
    {
        return [
            'author' => User::class
        ];
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
        return $this->setCreatedAt($date_inserted);
    }
    public function setDate_updated($date_updated)
    {
        return $this->setUpdatedAt($date_updated);
    }
    public function setSlug($slug)
    {
        $this->slug=$slug;
        return $this;
    }
    public function setAuthor(User $author): Article
    {
        $this->author=$author;
        return $this;
    }
    public function setPublish($publish)
    {
        $this->publish=$publish;
        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }
    public function getContent()
    {
        return $this->content;
    }
    public function getSlug()
    {
        return $this->slug;
    }
    public function getAuthor(): User
    {
        return $this->author;
    }
    public function getPublish()
    {
        return $this->publish;
    }
    public function getDate_inserted()
    {
        return $this->getCreatedAt();
    }
    public function getDate_updated()
    {
        return $this->getUpdatedAt();
    }

    public static function getShowArticleTable($articles){
        $tabArticles = [];
        foreach($articles as $article){

            $author = (new UserManager)->find($article->getAuthor()->getId());
        
            $tabArticles[] = [
                "id" => $article->getId(),
                "title" => $article->getTitle(),
                "slug" => $article->getSlug(),
                "publish" => ($article->getPublish() == true) ? "Oui" : "Non",
                "author" => $author->getLastname()." ".$author->getFirstname(),
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
                "Slug",
                "Publié",
                "Auteur",
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