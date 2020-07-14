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
        $today = date('Y-m-d', time());
        $where = "date_inserted = '" . $today . "'";

        $this->getDashboardInfos($response, $where);
    }

    public function month(Request $request, Response $response)
    {
        $mont = date('m', time());
        $where = "(date_inserted, '%m') = '" . $mont . "'";

        $this->getDashboardInfos($response, $where);
    }

    public function lastThreeMonths(Request $request, Response $response)
    {
        $mont = date('m', strtotime('-2 month'));
        $where = "(date_inserted, '%m') >= '" . $mont . "'";

        $this->getDashboardInfos($response, $where);
    }

    public function year(Request $request, Response $response)
    {
        $year = date('Y', time());
        $where = "(date_inserted, '%Y') = '" . $year . "'";

        $this->getDashboardInfos($response, $where);
    }

    public function all(Request $request, Response $response)
    {
        $this->getDashboardInfos($response);
    }

    public function getDashboardInfos(Response $response, string $where = null){
        $orders = (new QueryBuilder())
            ->select('*')
            ->from('orders', 'o');
        
        if(null !== $where)
            $orders->where("date = '". $where . "'");

        $orders->getQuery()
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
        $ordersOnSite = [];
        $ordersTakeOut = [];
        $caTotal = 0;

        foreach($orders as $order){
            if($order->getStatus() === "En cours"){
                array_push($ordersInProgress, $order);
            } else {
                array_push($ordersCompleted, $order);
            }

            if((bool) $order->getSurPlace() === true){
                array_push($ordersOnSite, $order);
            } else {
                array_push($ordersTakeOut, $order);
            }

            $caTotal += $order->getPrix();
        }
        
        $totalOrdersInProgress = count($ordersInProgress);
        $totalOrdersCompleted = count($ordersCompleted);
        $totalOrdersOnSite = count($ordersOnSite);
        $totalOrdersTakeOut = count($ordersTakeOut);

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