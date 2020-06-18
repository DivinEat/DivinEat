<?php
namespace App\Managers;

use App\Core\Manager;
use App\Models\Menu;

class OrderManager extends Manager {
    
    public function __construct(){
        parent::__construct(Order::class, 'orders');
    }
}