<?php

namespace App\Controllers;

use App\Core\Controller\Controller;
use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\View;

class UnauthorizedController extends Controller
{
    public function show(Request $request, Response $response)
    {
        $error = '403 : Vous n\'êtes pas autorisé ici bas';

        $myView = new View("403", "account");
        $myView->assign("error", $error);
    }
}