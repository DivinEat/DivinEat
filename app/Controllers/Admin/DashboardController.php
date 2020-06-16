<?php

namespace App\Controllers\Admin;

use App\Core\Controller\Controller;
use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\View;

class DashboardController extends Controller
{
    public function index(Request $request, Response $response)
    {
        $myView = new View("admin.dashboard", "admin");
    }
}