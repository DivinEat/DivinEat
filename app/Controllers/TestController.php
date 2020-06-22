<?php

namespace App\Controllers;

use App\Core\Controller\Controller;
use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\Routing\Router;

class TestController extends Controller
{
    public function index(Request $request, Response $response, array $args)
    {
        echo '<pre>';
//        var_dump($_SERVER["REQUEST_URI"]);
        var_dump(Router::getRouteList());
    }
}