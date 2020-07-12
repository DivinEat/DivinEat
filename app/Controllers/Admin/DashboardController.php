<?php

namespace App\Controllers\Admin;

use App\Models\User;
use App\Models\Order;
use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\Builder\QueryBuilder;
use App\Core\Controller\Controller;

class DashboardController extends Controller
{
    public function index(Request $request, Response $response)
    {
        $where = date('Y-m-d', time());

        $orders = (new QueryBuilder())
            ->select('*')
            ->from('orders', 'o')
            ->where("date = '". $where . "'")
            ->getQuery()
            ->getArrayResult(Order::class);
        
        $users = (new QueryBuilder())
            ->select('*')
            ->from('users', 'u')
            ->where("dateInserted >= '". $where . "%'")
            ->getQuery()
            ->getArrayResult(User::class);

        $total = count($orders);
        
        $ordersInProgress = [];
        $ordersCompleted = [];
        foreach($orders as $order){
            if($order->getStatus() === "En cours"){
                array_push($ordersInProgress, $order);
            } else {
                array_push($ordersCompleted, $order);
            }
        }
        $totalOrdersInProgress = count($ordersInProgress);
        $totalOrdersCompleted = count($ordersCompleted);

        $ordersOnSite = [];
        $ordersTakeOut = [];
        foreach($orders as $order){
            if((bool) $order->getSurPlace() === true){
                array_push($ordersOnSite, $order);
            } else {
                array_push($ordersTakeOut, $order);
            }
        }
        $totalOrdersOnSite = count($ordersOnSite);
        $totalOrdersTakeOut = count($ordersTakeOut);

        $caTotal = 0;
        foreach($orders as $order){
            $caTotal += $order->getPrix();
        }

        $newUsers = 0;
        $visitors = 0;
        foreach($users as $user){
            if((bool) $user->getStatus() === true){
                $newUsers += 1;
            } else {
                $visitors += 1;
            }
        }
        
        $response->render("admin.dashboard", "admin", [
            "total" => $total,
            "totalOrdersInProgress" => $totalOrdersInProgress,
            "totalOrdersCompleted" => $totalOrdersCompleted,
            "totalOrdersOnSite" => $totalOrdersOnSite,
            "totalOrdersTakeOut" => $totalOrdersTakeOut,
            "caTotal" => $caTotal,
            "visitors" => $visitors,
            "newUsers" => $newUsers,
        ]);
    }
}