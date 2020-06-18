<?php
namespace App\Managers;

use App\Core\Manager;
use App\Models\Horaire;

class HoraireManager extends Manager {
    
    public function __construct(){
        parent::__construct(Horaire::class, 'horaires');
    }
}