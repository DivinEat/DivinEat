<?php

namespace App\Models;

use App\Core\Model\Model;
use App\Core\Model\ModelInterface;
use App\Core\Routing\Router;

class Configuration extends Model implements ModelInterface
{
    protected $libelle;
    protected $info;

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
        $this->libelle=$libelle;
        return $this;
    }
    public function setInfo($info)
    {
        $this->info=$info;
        return $this;
    }

    public function getLibelle()
    {
        return $this->libelle;
    }
    public function getInfo()
    {
        return $this->info;
    }
}