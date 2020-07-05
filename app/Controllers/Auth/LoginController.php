<?php

namespace App\Controllers\Auth;

use App\Core\Controller\Controller;
use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Forms\Auth\LoginForm;

class LoginController extends Controller
{
    public function showLoginForm(Request $request, Response $response)
    {
        $form = $response->createForm(LoginForm::class);

        $response->render("auth.login", "account", ["loginForm" => $form]);
    }

    public function login(Request $request, Response $response)
    {
        echo "login";
    }
}