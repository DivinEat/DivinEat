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

        if (false === $form->handle($request)) {
            return $response->render("auth.register", "account", ["registerForm" => $form]);
        }

        $token = bin2hex(random_bytes(16));

        $userManager->create([
            'firstname' => $request->get('firstname'),
            'lastname' => $request->get('lastname'),
            'email' => $request->get('email'),
            'token' => $token,
            'pwd' => password_hash($request->get('pwd'), PASSWORD_DEFAULT),
            'status' => 0,
            'role' => current((new RoleManager())->findBy(['libelle' => 'Membre']))->getId(),
        ]);

        RegisterMail::sendMail($request->get('email'), '', $token);

        Router::redirect('auth.login');
    }

    public function token(Request $request, Response $response, array $args)
    {
        $user = current((new UserManager())->findBy(['token' => $args['token']]));
        if ($args['token'] == '' || false === $user)
            return Router::redirect('home');

        $user->setToken('');
        $user->setStatus(1);
        (new UserManager())->save($user);

        Auth::saveUser($user);

        return Router::redirect('home');
    }
}