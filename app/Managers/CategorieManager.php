<?php

namespace App\Managers;

use App\Core\Manager;
use App\Models\Categorie;

class CategorieManager extends Manager
{

    public function __construct()
    {
        parent::__construct(Categorie::class, 'categories');
    }
}
