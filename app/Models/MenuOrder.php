<?php

namespace App\Models;

use App\Core\Model\Model;
use App\Core\Model\ModelInterface;
use App\Core\Routing\Router;
use App\Models\Order;
use App\Models\Menu;

class MenuOrder extends Model implements ModelInterface
{
    protected $menu;
    protected $order;

    public function __construct()
    {
        parent::__construct();
    }

    public function initRelation(): array
    {
        return [
            'menu' => Menu::class,
            'order' => Order::class
        ];
    }

    public function setMenu(Menu $menu): MenuOrder
    {
        $this->menu=$menu;
        return $this;
    }
    public function setOrder(Order $order): MenuOrder
    {
        $this->order = $order;
        return $this;
    }

    public function getMenu(): Menu
    {
        return $this->menu;
    }
    public function getOrder(): Order
    {
        return $this->order;
    }
}