<?php

namespace App\Controllers\Auth;

use App\Core\Controller\Controller;
use App\Core\Http\Request;
use App\Core\Http\Response;

class LoginController extends Controller
{
    public function showLoginForm(Request $request, Response $response)
    {
        echo "test";
    }
}