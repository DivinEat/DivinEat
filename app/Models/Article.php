<?php

namespace App\Models;

use App\Models\User;
use App\Core\Model\Model;
use App\Models\Categorie;
use App\Core\Model\ModelInterface;

class Article extends Model implements ModelInterface
{
    protected $title;
    protected $content;
    protected $slug;
    protected $author;
    protected $categorie;
    protected $publish;

    public function __construct(){
        parent::__construct();
    }

    public function initRelation(): array
    {
        return [
            'author' => User::class,
            'categorie' => Categorie::class
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
    public function setCategorie(Categorie $categorie): Article
    {
        $this->categorie=$categorie;
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
    public function getCategorie(): Categorie
    {
        return $this->categorie;
    }
    public function getPublish()
    {
        return $this->publish;
    }
}