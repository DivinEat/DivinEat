<?php

namespace App\Controllers\Auth;

use App\Core\Controller\Controller;
use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Forms\Auth\RegisterForm;

class RegisterController extends Controller
{
    public function showRegisterForm(Request $request, Response $response)
    {
        $form = $response->createForm(RegisterForm::class);

        $response->render("auth.register", "account", ["registerForm" => $form]);
    }

    public function register(Request $request, Response $response)
    {
        echo "register";
    }
}