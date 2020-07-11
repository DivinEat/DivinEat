<?php

namespace App\Controllers;

use App\Core\Controller\Controller;
use App\Core\Http\Request;
use App\Core\Http\Response;

class UnauthorizedController extends Controller
{
    public function show(Request $request, Response $response)
    {
        echo '403 : Vous n\'êtes pas autorisé ici bas';
    }
}