<?php

namespace App\Controllers\Admin;

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
        $request->setInputPrefix('createFormOrder_');

        $order = (new Order())->hydrate([
            "horaire" => $request->get("horaire"),
            "surPlace" => $request->get("surPlace"),
        ]);

        $form = $response->createForm(CreateOrderForm::class, $order);

        if (false === $form->handle($request)) {
            return $response->render("admin.order.create", "admin", ["createOrderForm" => $form]);
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
        return Router::redirect('admin.order.index');

    }

    public function edit(Request $request, Response $response, array $args)
    {
        $order = (new OrderManager())->find($args['order_id']);
        if (null === $order)
            return Router::redirect('admin.order.index');

        $form = $response->createForm(UpdateOrderForm::class, $order);

        $response->render("admin.order.edit", "admin", ["updateOrderForm" => $form]);
    }

    public function update(Request $request, Response $response, array $args)
    {
        $orderManager = new OrderManager();
        $menuOrderManager = new MenuOrderManager();
        $userManager = new UserManager();
        $menuManager = new MenuManager();

        $order = (new OrderManager())->find($args['order_id']);
        if (null === $order)
            return Router::redirect('admin.order.index');

        $request->setInputPrefix('updateFormOrder_');

        $order = (new Order())->hydrate([
            'id' => $order->getId(),
            "horaire" => $request->get("horaire"),
            "surPlace" => $request->get("surPlace")
        ]);

        $form = $response->createForm(UpdateOrderForm::class, $order);

        if (false === $form->handle($request)) {
            $response->render("admin.order.edit", "admin", ["updateOrderForm" => $form]);
        }

        $oldOrder = $orderManager->find($args['order_id']);
        $oldMenuOrders = $menuOrderManager->findBy(["order" => $oldOrder->getId()]);
        if (!empty($oldMenuOrders)) {
            foreach ($oldMenuOrders as $key => $menuOrder) {
                $menuOrderManager->delete($menuOrder->getId());
            }
        }

        $user = $userManager->findBy(["email" => $request->get('email')]);
        if (empty($user)) {
            $user = $userManager->create([
                'email' => $email,
                'role' => current((new RoleManager())->findBy(['libelle' => 'Membre']))->getId(),
            ]);
        } else {
            $user = current($user);
        }

        $index_menus = 0;
        $prix = 0;
        $menus = [];

        while(null !== $request->get('menu'.$index_menus)) {
            $menu = $request->get('menu'.$index_menus);
            $prix += ($menuManager->find($menu))->getPrix();
            array_push($menus, $menu);
            $index_menus++;
        }

        $order->setUser($user);
        $order->setDate($request->get('date'));
        $order->setPrix($prix);
        $order->setStatus($request->get('status'));

        $orderManager->save($order);



        foreach ($menus as $menu) {
            $menuOrder = (new MenuOrderManager())->create([
                'menu' => $menu,
                'order' => $order->getId()
            ]);
        }

        Router::redirect('admin.order.edit', [$order->getId()]);
    }

    public function destroy(Request $request, Response $response, array $args)
    {
        $orderId = $args['order_id'];

        (new QueryBuilder())
            ->delete("menu_order")
            ->where("`order` = $orderId")
            ->getQuery()
            ->getArrayResult(MenuOrder::class);

        $manager = new OrderManager();
        $manager->delete($orderId);

        Router::redirect('admin.order.index');
    }
}
