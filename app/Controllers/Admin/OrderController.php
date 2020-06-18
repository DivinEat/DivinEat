<?php

namespace App\Controllers\Admin;

use App\Core\Controller\Controller;
use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\Routing\Router;
use App\Core\View;
use App\Models\Order;
use App\Managers\OrderManager;

class OrderController extends Controller
{
    public function index(Request $request, Response $response)
    {
        $myView = new View("admin.order.index", "admin");
    }

    public function create(Request $request, Response $response, array $args)
    {
        $myView = new View("admin.order.create", "admin");
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