<?php
namespace App\models;

use App\core\Model;
use App\models\User;
use JSONSerializable;

class Post extends Model
{
    protected $id;
    protected $title;
    protected $author;
    protected $relations;

    public function __construct(){
        parent::__construct();
        $this->initRelation();
    }

    public function setId($id)
    {
        $this->id=$id;
    }
    public function setTitle($title)
    {
        $this->title=ucwords(strtolower(trim($title)));
    }
    public function setAuthor($author)
    {
        $this->author=$author;
    }

    public function getId()
    {
        return $this->id;
    }

    public function initRelation(): array 
    {
        $this->relations = [
            "author" => User::class
        ]
    }
}