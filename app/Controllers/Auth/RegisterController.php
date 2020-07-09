<?php

namespace App\Controllers\Auth;

use App\Core\Controller\Controller;
use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\Routing\Router;
use App\Forms\Auth\RegisterForm;
use App\Managers\RoleManager;
use App\Managers\UserManager;
use App\Models\User;

class RegisterController extends Controller
{
    public function showRegisterForm(Request $request, Response $response)
    {
        $form = $response->createForm(RegisterForm::class);

        $response->render("auth.register", "account", ["registerForm" => $form]);
    }

    public function register(Request $request, Response $response)
    {
        $request->setInputPrefix('registerForm_');
        $userManager = new UserManager();

        $user = $userManager->findBy(['email' => $request->get('email')]);

        //TODO : Thibault modifie avec le form builder
        if ([] !== $user || $request->get('pwd') !== $request->get('pwdConfirm'))
            return Router::redirect('auth.register');

        $userManager->save((new User())->hydrate([
            'firstname' => $request->get('firstname'),
            'lastname' => $request->get('lastname'),
            'email' => $request->get('email'),
            'pwd' => password_hash($request->get('pwd'), PASSWORD_DEFAULT),
            'role' => current((new RoleManager())->findBy(['libelle' => 'Membre']))->getId(),
        ]));

        return Router::redirect('home');
    }
}