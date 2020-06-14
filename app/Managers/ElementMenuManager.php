<?php
namespace App\Managers;

use App\Core\Manager;
use App\Models\ElementMenu;

class ElementMenuManager extends Manager {
    
    public function __construct(){
        parent::__construct(ElementMenu::class, 'elementmenus');
    }
}