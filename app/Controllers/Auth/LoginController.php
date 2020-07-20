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
        $request->setInputPrefix('loginForm_');
        $userManager = new UserManager();
        
        $user = current($userManager->findBy(['email' => $request->get('email')]));

        $form = $response->createForm(LoginForm::class);

        if (false === $user || !password_verify($request->get('pwd'), $user->getPwd()))
            $form->addErrors(["login" => "Votre mot de passe est incorrect"]);

        if (! empty($user) && $user->getStatus() === 0)
            $form->addErrors(["login" => "Vous devez vérifier votre email."]);

        if (false === $form->handle($request)) {
            return $response->render("auth.login", "account", ["loginForm" => $form]);
        }

        Auth::saveUser($user);

        return Router::redirect('home');
    }
}