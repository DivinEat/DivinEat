<?php

namespace App\Controllers\Admin;

use App\Core\View;
use App\Models\User;
use App\Models\Order;
use App\Models\MenuOrder;
use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\Routing\Router;
use App\Managers\MenuManager;
use App\Managers\RoleManager;
use App\Managers\UserManager;
use App\Managers\OrderManager;
use App\Managers\HoraireManager;
use App\Managers\MenuOrderManager;
use App\Core\Controller\Controller;
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
        $data = $_POST;

        foreach($data as $elementName => $element) {
            $data[explode("_", $elementName)[1]] = $data[$elementName];
            unset($data[$elementName]);
        }

        $userManager = new UserManager();
        $menuManager = new MenuManager();
        $horaireManager = new HoraireManager();

        $order = new Order();
        $menuOrder = new MenuOrder();

        $email = $data['email'];

        $user = $userManager->findBy(["email" => $email]);
        if (empty($user)) {
            $user = new User();
            $user->setEmail($email);
            $user->setRole((new RoleManager())->find(4));
            $userManager->save($user);
            $user = $userManager->findBy(["email" => $email]);
        }
        
        $user = $user[0];
        $menu = $menuManager->find($data['menu']);

        $data['user'] = $user->getId();
        $data['date'] = date('Y-m-d', time());
        $data['prix'] = $menu->getPrix(); // somme de tt les menus quand y'en aura plusieurs

        $order = (new Order())->hydrate($data);

        $form = $response->createForm(CreateOrderForm::class, $order);

        if (false === $form->handle()) {
            $response->render("admin.order.create", "admin", ["createOrderForm" => $form]);
        } else {
            (new OrderManager())->save($order);
            $order = (new OrderManager())->findBy(["id" => 7]);
            $order = $order[0];
            $menuOrder->setMenu($menu);
            $menuOrder->setOrder($order);
            (new MenuOrderManager())->save($menuOrder);       
            Router::redirect('admin.order.index');
        }
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