<?php

namespace App\Models;

use App\Core\Model;
use App\Core\helpers;
use App\Models\User;

class Post extends Model
{
    protected $id;
    protected $content;
    protected $user_id;
    protected $date_inserted;
    protected $date_updated;
    protected $relation;


    public function __construct()
    {
        parent::__construct();
        $this->initRelation();
    }

    public function initRelation() {
       $this->relation = [
           'author' => User::class
       ];
   }

    public function setId($id)
    {
        $this->id=$id;
    }
    public function getId()
    {
        return $this->id;
    }

    public function setContent($content)
    {
        $this->content=$content;
    }
    public function getContent()
    {
        return $this->content;
    }

    public function setUser_id($user_id)
    {
        $this->user_id=$user_id;
    }
    public function getUser_id()
    {
        return $this->user_id;
    }

    public function setDate_inserted($date_inserted)
    {
        $this->date_inserted=$date_inserted;
    }
    public function setDate_updated($date_updated)
    {
        $this->date_updated=$date_updated;
    }
}












