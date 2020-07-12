<?php

namespace App\Controllers\Auth;

use App\Core\Auth;
use App\Core\Controller\Controller;
use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\Mail;
use App\Core\Routing\Router;
use App\Forms\Auth\RegisterForm;
use App\Mails\RegisterMail;
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
        $userManager = new UserManager();
        $request->setInputPrefix('registerForm_');

        $form = $response->createForm(RegisterForm::class);

        if ($request->get('pwd') !== $request->get('pwdConfirm'))
            $form->addErrors(["confirmPwd" => "Les mots de passe ne correspondent pas"]);

        if (false === $form->handle()) {
            return $response->render("auth.register", "account", ["registerForm" => $form]);
        }

        $user = $userManager->create([
            'firstname' => $request->get('firstname'),
            'lastname' => $request->get('lastname'),
            'email' => $request->get('email'),
            'pwd' => password_hash($request->get('pwd'), PASSWORD_DEFAULT),
            'role' => current((new RoleManager())->findBy(['libelle' => 'Membre']))->getId(),
        ]);

        Auth::saveUser($user);
        RegisterMail::sendMail($request->get('email'));

        return Router::redirect('home');
    }   
}