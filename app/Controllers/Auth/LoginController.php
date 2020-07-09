<?php

namespace App\Controllers\Auth;

use App\Core\Auth;
use App\Core\Controller\Controller;
use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Forms\Auth\LoginForm;
use App\Managers\UserManager;
use App\Core\Routing\Router;

class LoginController extends Controller
{
    public function showLoginForm(Request $request, Response $response)
    {
        $form = $response->createForm(LoginForm::class);

        $response->render("auth.login", "account", ["loginForm" => $form]);
    }

    public function login(Request $request, Response $response)
    {
        $userManager = new UserManager();
        $user = current($userManager->findBy(['email' => $request->get('loginForm_email')]));

        if (false === $user || !password_verify($request->get('loginForm_pwd'), $user->getPwd()))
            return Router::redirect('auth.login');

        Auth::saveUser($user);

        return Router::redirect('home');

    }
}