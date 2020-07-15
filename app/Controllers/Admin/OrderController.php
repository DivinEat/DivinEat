<?php

namespace App\Controllers\Admin;

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
use App\Forms\Order\UpdateOrderForm;



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

        $order = (new Order())->hydrate($data);

        $form = $response->createForm(CreateOrderForm::class, $order);

        if (false === $form->handle()) {
            return $response->render("admin.order.create", "admin", ["createOrderForm" => $form]);
        }

        $userManager = new UserManager();
        $menuManager = new MenuManager();
        $orderManager = new OrderManager();
        $menuOrderManager = new MenuOrderManager();
        
        $email = $data['email'];

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
        $prix = ($menuManager->find($data['menu']))->getPrix();
        $menus = [$data['menu']];

        while(isset($data['menu'.$index_menus])) {
            $menu = $data['menu'.$index_menus]; 
            $prix += ($menuManager->find($menu))->getPrix();
            array_push($menus, $menu);
            $index_menus++;
        }

        $order->setUser($user);
        $order->setDate($data['date']);
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
        $id = $args['order_id'];

        if(isset($id)){
            $orderManager = new OrderManager();
            $order = $orderManager->find($id);
        } else {
            throw new \Exception("L'id de la commande n'existe pas.");
        }
        
        $form = $response->createForm(UpdateOrderForm::class, $order);
        
        $response->render("admin.order.edit", "admin", ["updateOrderForm" => $form]);
    }

    public function update(Request $request, Response $response, array $args)
    {
        $data = $_POST;

        $orderManager = new OrderManager();
        $menuOrderManager = new MenuOrderManager();
        $userManager = new UserManager();
        $menuManager = new MenuManager();

        foreach($data as $elementName => $element) {
            $data[explode("_", $elementName)[1]] = $data[$elementName];
            unset($data[$elementName]);
        }

        $data['id'] = $args['order_id'];

        $order = (new Order())->hydrate($data);

        $form = $response->createForm(UpdateOrderForm::class, $order);
        
        if (false === $form->handle()) {
            $response->render("admin.order.edit", "admin", ["updateOrderForm" => $form]);
        }

        $oldOrder = $orderManager->find($args['order_id']);
        $oldMenuOrders = $menuOrderManager->findBy(["order" => $oldOrder->getId()]);
        if (!empty($oldMenuOrders)) {
            foreach ($oldMenuOrders as $key => $menuOrder) {
                $menuOrderManager->delete($menuOrder->getId());
            }
        }
        
        $user = $userManager->findBy(["email" => $data['email']]);
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

        while(isset($data['menu'.$index_menus])) {
            $menu = $data['menu'.$index_menus]; 
            $prix += ($menuManager->find($menu))->getPrix();
            array_push($menus, $menu);
            $index_menus++;
        }

        $order->setUser($user);
        $order->setDate($data['date']);
        $order->setPrix($prix);
        $order->setStatus($data['status']);

        $orderManager->save($order);

        
        foreach ($menus as $menu) {
            $menuOrder = (new MenuOrderManager())->create([
                'menu' => $menu,
                'order' => $order->getId()
            ]);
        }
        
        Router::redirect('admin.order.index');
    }

    public function destroy(Request $request, Response $response, array $args)
    {
        $manager = new OrderManager();
        $manager->delete($args["order_id"]);

        Router::redirect('admin.order.index');
    }
}