<?php

namespace App\Models;

use App\Core\Model\Model;
use App\Core\Model\ModelInterface;

class Role extends Model implements ModelInterface
{
    protected $libelle;

    public function __construct()
    {
        parent::__construct();
    }

    public function initRelation(): array
    {
        return [];
    }

    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;
        return $this;
    }

    public function getLibelle()
    {
        return $this->libelle;
    }
}