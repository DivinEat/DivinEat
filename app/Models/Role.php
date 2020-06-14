<?php

namespace App\Models;

use App\Core\Model\Model;

class Role extends Model
{
    protected $id;
    protected $libelle;

    public function __construct()
    {
        parent::__construct();
    }

    public function initRelation(){
        return [];
    }

    public function setId($id)
    {
        $this->id = $id;
    }
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getLibelle()
    {
        return $this->libelle;
    }
}