<?php
namespace App\Managers;

use App\Core\Manager;
use App\Models\Configuration;

class ConfigurationManager extends Manager {
    
    public function __construct(){
        parent::__construct(Configuration::class, 'configurations');
    }
}