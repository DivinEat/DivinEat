<?php

namespace App\Controllers;

use App\Core\Controller\Controller;
use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\View;

class HomeController extends Controller
{
    public function index(Request $request, Response $response)
    {
        $firstname = 'test';
        $myView = new View("admin.dashboard");
        $myView->assign("firstname", $firstname);
    }
}