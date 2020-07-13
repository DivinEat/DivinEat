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

        $userManager = new UserManager();
        $menuManager = new MenuManager();
        $horaireManager = new HoraireManager();
        $orderManager = new OrderManager();

        $order = new Order();

        $email = $data['email'];

        $user = $userManager->findBy(["email" => $email]);
        if (empty($user)) {
            $user = new User();
            $user->setEmail($email);
            $user->setRole((new RoleManager())->findBy(['libelle' => 'Membre'])->getId());
            $user = $userManager->find($userManager->save($user));
        } else {
            $user = $user[0];
        }

        $index_menus = 0;
        $prix = 0;
        $menus = [$data['menu']];

        while(isset($data['menu'.$index_menus])) {
            $menu = $data['menu'.$index_menus]; 
            $prix += ($menuManager->find($menu))->getPrix();
            array_push($menus, $menu);
            $index_menus++;
        }

        $data['user'] = $user->getId();
        $data['date'] = date('Y-m-d', time());
        $data['prix'] = $prix;
        $data['status'] = "En cours";
        
        $order = (new Order())->hydrate($data);

        $form = $response->createForm(CreateOrderForm::class, $order);

        if (false === $form->handle($request)) {
            $response->render("admin.order.create", "admin", ["createOrderForm" => $form]);
        } else {
            
            $order_id = $orderManager->save($order);
            $order = $orderManager->find($order_id);

            foreach ($menus as $menu) {
                $menuOrder = new MenuOrder();
                $menuOrder->setMenu((new MenuOrderManager())->find($menu));
                $menuOrder->setOrder($order);
                (new MenuOrderManager())->save($menuOrder); 
            }
            
            Router::redirect('admin.order.index');
        }
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

        $oldOrder = $orderManager->find($args['order_id']);
        $oldMenuOrders = $menuOrderManager->findBy(["order" => $oldOrder->getId()]);
        if (!empty($oldMenuOrders)) {
            foreach ($oldMenuOrders as $key => $menuOrder) {
                $menuOrderManager->delete($menuOrder->getId());
            }
        }
        
        $user = $userManager->findBy(["email" => $data['email']]);
        if (empty($user)) {
            $user = new User();
            $user->setEmail($data['email']);
            $user->setRole((new RoleManager())->findBy(['libelle' => 'Membre'])[0]);
            $user = $userManager->find($userManager->save($user));
        } else {
            $user = $user[0];
        }

        $menu = $menuManager->find($data['menu']);

        $data['id'] = $args['order_id'];
        $data['user'] = $user->getId();
        $data['prix'] = $menu->getPrix();
        $data['date'] = date('Y-m-d', time());
        $data['status'] = $oldOrder->getStatus();

        $order = (new Order())->hydrate($data);

        $form = $response->createForm(UpdateOrderForm::class, $order);
        
        if (false === $form->handle($request)) {
            $response->render("admin.order.edit", "admin", ["updateOrderForm" => $form]);
        } else {
            $orderManager->save($order);  
            $order = $orderManager->find($oldOrder->getId());
            
            $menuOrder = new MenuOrder();
            $menuOrder->setMenu($menu);
            $menuOrder->setOrder($order);
            $menuOrderManager->save($menuOrder);
            
            Router::redirect('admin.order.index');
        }
    }

    public function destroy(Request $request, Response $response, array $args)
    {
        $manager = new OrderManager();
        $manager->delete($args["order_id"]);

        Router::redirect('admin.order.index');
    }
}