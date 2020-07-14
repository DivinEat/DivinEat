<?php
namespace App\Managers;

use App\Core\Manager;
use App\Models\NavbarElement;

class NavbarElementManager extends Manager {
    
    public function __construct(){
        parent::__construct(NavbarElement::class, 'navbar_elements');
    }
}