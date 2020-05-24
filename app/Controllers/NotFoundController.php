<?php

namespace App\Controllers;

use App\Core\Controller\Controller;
use App\Core\Http\Request;
use App\Core\Http\Response;

class NotFoundController extends Controller
{
    public function show(Request $request, Response $response)
    {
        echo '404 : J\'ai po trouvé grand chose';
    }
}