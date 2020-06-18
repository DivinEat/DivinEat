<?php
namespace App\Managers;

use App\Core\Manager;
use App\Models\MenuOrder;

class MenuOrderManager extends Manager {
    
    public function __construct(){
        parent::__construct(MenuOrder::class, 'menu_order');
    }
}