<?php

namespace App\Controllers\Admin;

use App\Models\Order;
use App\Core\Controller\Controller;
use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\Routing\Router;
use App\Core\View;
use App\Managers\UserManager;
use App\Managers\OrderManager;
use App\Forms\FormTest;
use App\Forms\Order\CreateOrderForm;

class OrderController extends Controller
{
    public function index(Request $request, Response $response)
    {
        // Test form
        $OrderManager = new OrderManager();
        $orders = $OrderManager->findAll();

        $configTableOrder = Order::getShowOrderTable($orders);

        $response->render("admin.order.index", "admin", ["configTableOrder" => $configTableOrder]);

    }

    public function create(Request $request, Response $response, array $args)
    {   
        $form = $response->createForm(CreateOrderForm::class);

        $response->render("admin.order.create", "admin", ["createOrderForm" => $form]);
    }

    public function store(Request $request, Response $response, array $args)
    {
    }

    public function edit(Request $request, Response $response, array $args)
    {
        $myView = new View("admin.order.edit", "admin");
    }

    public function update(Request $request, Response $response, array $args)
    {

    }

    public function destroy(Request $request, Response $response, array $args)
    {

    }
}