<?php

namespace App\Controllers;

use App\Core\Controller\Controller;
use App\Core\Http\Request;
use App\Core\Http\Response;

class HomeController extends Controller
{
    public function index(Request $request, Response $response)
    {
        $myView = new View("dashboard");
        $myView->assign("firstname", $firstname);
    }
}