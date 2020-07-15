<?php

namespace App\Controllers\Admin;

use App\Models\User;
use App\Models\Order;
use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Managers\UserManager;
use App\Managers\OrderManager;
use App\Managers\ArticleManager;
use App\Core\Builder\QueryBuilder;
use App\Core\Controller\Controller;

class DashboardController extends Controller
{
    public function index(Request $request, Response $response)
    {
        $today = date('Y-m-d', time());
        $whereOrder = "date = '" . $today . "'";
        $whereUser = "dateInserted = '" . $today . "'";

        $this->getDashboardInfos($response, $whereOrder, $whereUser);
    }

    public function month(Request $request, Response $response)
    {
        $mont = date('m', time());
        $whereOrder = "month(date) = '" . $mont . "'";
        $whereUser = "month(dateInserted) = '" . $mont . "'";

        $this->getDashboardInfos($response, $whereOrder, $whereUser);
    }

    public function year(Request $request, Response $response)
    {
        $year = date('Y', time());
        $whereOrder = "year(date) = '" . $year . "'";
        $whereUser = "year(dateInserted) = '" . $year . "'";

        $this->getDashboardInfos($response, $whereOrder, $whereUser);
    }

    public function all(Request $request, Response $response)
    {
        $this->getDashboardInfos($response);
    }

    public function getDashboardInfos(Response $response, string $whereOrder = null, string $whereUser = null){
        if(null != $whereOrder){
            $orders = (new QueryBuilder())->select('*')->from('orders', 'o')->where($whereOrder)->getQuery()->getArrayResult(Order::class);
        } else {
            $orders = (new OrderManager())->findAll();
        }

        if(null != $whereUser){
            $users = (new QueryBuilder())->select('*')->from('users', 'u')->where($whereUser)->getQuery()->getArrayResult(User::class);
        } else {
            $users = (new UserManager())->findAll();
        }

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

        $articles = (new ArticleManager)->findAll();
        $totalArticles = count($articles);
        
        $response->render("admin.dashboard", "admin", [
            "total" => $total,
            "totalOrdersInProgress" => $totalOrdersInProgress,
            "totalOrdersCompleted" => $totalOrdersCompleted,
            "totalOrdersOnSite" => $totalOrdersOnSite,
            "totalOrdersTakeOut" => $totalOrdersTakeOut,
            "caTotal" => $caTotal,
            "visitors" => $visitors,
            "newUsers" => $newUsers,
            "totalArticles" => $totalArticles,
        ]);
    }
}