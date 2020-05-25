<?php

namespace App\Controllers;

use App\Core\Http\Request;
use App\Core\Http\Response;

class UnauthorizedController
{
    public function show(Request $request, Response $response)
    {
        echo '403 : Vous n\'êtes pas autorisé ici bas';
    }
}