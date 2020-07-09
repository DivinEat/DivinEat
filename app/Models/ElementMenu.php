<?php

namespace App\Models;

use App\Core\Model\Model;
use App\Core\Model\ModelInterface;

class ElementMenu extends Model implements ModelInterface
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

    public function initRelation(): array
    {
        return [];
    }

    public function setId(int $id): self
    {
        $this->id=$id;
        return $this;
    }
    public function setCategorie($categorie)
    {
        $this->categorie=strtolower(trim($categorie));
        return $this;
    }
    public function setNom($nom)
    {
        $this->nom= $nom;
        return $this;
    }
    public function setDescription($description)
    {
        $this->description= $description;
        return $this;
    }
    public function setPrix($prix)
    {
        $this->prix= $prix;
        return $this;
    }

    public function getId(): ?int
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