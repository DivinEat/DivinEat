<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Models\Order;
use App\Models\MenuOrder;
use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\Routing\Router;
use App\Managers\MenuManager;
use App\Managers\RoleManager;
use App\Managers\UserManager;
use App\Managers\OrderManager;
use App\Core\Builder\QueryBuilder;
use App\Managers\MenuOrderManager;
use App\Core\Controller\Controller;
use App\Forms\Order\CreateOrderForm;
use App\Forms\Order\UpdateOrderForm;



class OrderController extends Controller
{
    public function index(Request $request, Response $response)
    {
        $user = Auth::getUser();
        $OrderManager = new OrderManager();
        $orders = $OrderManager->findBy(['user' => $user->getId() ]);

        $configTableOrder = Order::getClientShowOrderTable($orders);

        $response->render("order.index", "main", ["configTableOrder" => $configTableOrder]);

    }

    public function create(Request $request, Response $response, array $args)
    {
        $form = $response->createForm(CreateOrderForm::class);

        $response->render("order.create", "main", ["createOrderForm" => $form]);
    }

    public function store(Request $request, Response $response, array $args)
    {
        $request->setInputPrefix('createFormOrder_');

        $order = (new Order())->hydrate([
            "horaire" => $request->get("horaire"),
            "surPlace" => $request->get("surPlace"),
        ]);

        $form = $response->createForm(CreateOrderForm::class, $order);

        if (false === $form->handle($request)) {
            return $response->render("order.create", "main", ["createOrderForm" => $form]);
        }

        $userManager = new UserManager();
        $menuManager = new MenuManager();
        $orderManager = new OrderManager();

        $email = $request->get('email');

        $user = $userManager->findBy(["email" => $email]);

        if (empty($user)) {
            $user = $userManager->create([
                'email' => $email,
                'role' => current((new RoleManager())->findBy(['libelle' => 'Membre']))->getId(),
            ]);
        } else {
            $user = current($user);
        }

        $index_menus = 0;
        $prix = ($menuManager->find($request->get('menu')))->getPrix();
        $menus = [$request->get('menu')];

        while(null !== $request->get('menu'.$index_menus)) {
            $menu = $request->get('menu'.$index_menus);
            $prix += ($menuManager->find($menu))->getPrix();
            array_push($menus, $menu);
            $index_menus++;
        }

        $order->setUser($user);
        $order->setDate($request->get('date'));
        $order->setPrix($prix);
        $order->setStatus("En cours");

        $order_id = $orderManager->save($order);

        $order = $orderManager->find($order_id);

        foreach ($menus as $menu) {
            $menuOrder = (new MenuOrderManager())->create([
                'menu' => $menu,
                'order' => $order_id
            ]);
        }
        return Router::redirect('order.index');

    }
}
