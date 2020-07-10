<?php

namespace App\Controllers\Auth;

use App\Core\Auth;
use App\Core\Controller\Controller;
use App\Core\Routing\Router;

class LogoutController extends Controller
{
    public function logout()
    {
        Auth::unsaveUser();

        return Router::redirect('auth.login');
    }
}