<?php

namespace App\Models;

use App\Core\Model\Model;

class ElementMenu extends Model
{
    protected $id;
    protected $categorie;
    protected $nom;
    protected $description;
    protected $prix;

    public function __construct()
    {
        parent::__construct();
    }

    public function setId($id)
    {
        $this->id=$id;
    }
    public function setCategorie($categorie)
    {
        $this->categorie=strtolower(trim($categorie));
    }
    public function setNom($nom)
    {
        $this->nom=ucwords(strtolower($nom));
    }
    public function setDescription($description)
    {
        $this->nom=ucwords(strtolower($description));
    }
    public function setPrix($prix)
    {
        $this->prix=$prix;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getCategorie()
    {
        return $this->categorie;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getPrix()
    {
        return $this->prix;
    }
}