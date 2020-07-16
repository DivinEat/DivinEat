<?php

namespace App\Models;

use App\Core\Model\Model;
use App\Core\Model\ModelInterface;
use App\Core\Routing\Router;
use App\Models\User;
use App\Managers\UserManager;

class Article extends Model implements ModelInterface
{
    protected $id;
    protected $title;
    protected $content;
    protected $date_inserted;
    protected $date_updated;
    protected $slug;
    protected $author;

    public function __construct(){
        parent::__construct();
    }

    public function initRelation(): array
    {
        return [
            'author' => User::class
        ];
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
    public function getSlug()
    {
        return $this->slug;
    }
    public function getAuthor(): User
    {
        return $this->author;
    }
    public function getDate_inserted()
    {
        return $this->getCreatedAt();
    }
    public function getDate_updated()
    {
        return $this->getUpdatedAt();
    }

    public static function setJsonToHtml($content){
        $content = str_replace("'", "\"", $content);
        $json = json_decode($content);

        $html = "";
        foreach($json->blocks as $block){
            switch($block->type){
                case "header":
                    $html .= "<h".$block->data->level.">".$block->data->text."</h".$block->data->level.">";
                    break;
                case "paragraph":
                    $html .= "<p>".$block->data->text."</p>";
                    break;
                case "list":
                    if($block->data->style == "ordered"){
                        $html .= "<ol>";
                    } else {
                        $html .= "<ul>";
                    }
                    foreach($block->data->items as $value){
                        $html .= "<li>$value</li>";
                    }
                    if($block->data->style == "ordered"){
                        $html .= "</ol>";
                    } else {
                        $html .= "</ul>";
                    }
                    break;
            }
        }

        return $html;
    }

    public static function getShowArticleTable($articles){
        $tabArticles = [];
        foreach($articles as $article){

            $author = (new UserManager)->find($article->getAuthor()->getId());
        
            $tabArticles[] = [
                "id" => $article->getId(),
                "title" => $article->getTitle(),
                "slug" => $article->getSlug(),
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