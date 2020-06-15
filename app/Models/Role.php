<?php

namespace App\Models;

use App\Core\Model\Model;
use App\Core\Model\ModelInterface;

class Role extends Model implements ModelInterface
{
    protected $id;
    protected $libelle;

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
        $this->id = $id;
        return $this;
    }
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle()
    {
        return $this->libelle;
    }
}