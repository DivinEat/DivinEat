<?php

namespace App\Controllers;

use App\Core\Controller\Controller;
use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\View;

class NotFoundController extends Controller
{
    public function show(Request $request, Response $response)
    {
        $uri = $_SERVER["REQUEST_URI"];

        $myView = new View("404", "account");
        $myView->assign("uri", $uri);
    }
}