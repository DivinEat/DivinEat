<?php

namespace App\Controllers\Auth;

use App\Core\Auth;
use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\Mail;
use App\Core\Routing\Router;
use App\Mails\PasswordMail;
use App\Managers\UserManager;
use App\Core\Controller\Controller;
use App\Forms\Auth\NewPasswordForm;
use App\Forms\Auth\ForgotPasswordForm;

class ForgotPasswordController extends Controller
{
    public function showForgotPassword(Request $request, Response $response)
    {
        $form = $response->createForm(ForgotPasswordForm::class);

        $response->render("auth.forgot_password", "account", ["forgotPasswordForm" => $form]);
    }

    public function forgotPassword(Request $request, Response $response)
    {
        $request->setInputPrefix('forgotPasswordForm_');
        
        $form = $response->createForm(ForgotPasswordForm::class);
        
        if (false === $form->handle($request)) {
            return $response->render("auth.forgot_password", "account", ["forgotPasswordForm" => $form]);
        }

        $user = current((new UserManager())->findBy(['email' => $request->get('email')]));

        if (false !== $user)
        {
            $token = bin2hex(random_bytes(16));
            $user->setTokenPassword($token);
            $user->setDateTokenPassword(date('Y-m-d', time()));
            (new UserManager())->save($user);
            PasswordMail::sendMail($user->getEmail(), '', $token);
        }

        return Router::redirect('auth.show-forgot-password');
    }

    public function showNewPassword(Request $request, Response $response, array $args)
    {
        $user = current((new UserManager())->findBy(['token_password' => $args['token']]));

        if (null === $user ||
            (new \DateTime($user->getDateTokenPassword()))->diff(new \DateTime('now'))->d !== 0)
            return Router::redirect('home');

        $form = $response->createForm(NewPasswordForm::class);
        $form->addConfig("action", Router::getRouteByName("auth.new-password", [$args['token']])
            ->getUrl());

        $response->render("auth.new_password", "account", ["newPasswordForm" => $form]);
    }

    public function newPassword(Request $request, Response $response, array $args)
    {
        $user = current((new UserManager())->findBy(['token_password' => $args['token']]));

        if (null === $user ||
            (new \DateTime($user->getDateTokenPassword()))->diff(new \DateTime('now'))->d !== 0)
            return Router::redirect('home');

        $request->setInputPrefix('newPasswordForm_');

        $form = $response->createForm(NewPasswordForm::class, $user);

        if($request->get('pwd') != $request->get('confirmPwd')){
            $form->addErrors(["confirmPwd" => "Les mots de passe ne correspondent pas"]);
        } 

        if (false === $form->handle($request)) {
            return $response->render("auth.new_password", "account", ["newPasswordForm" => $form]);
        }

        $user->setPwd(password_hash($request->get('pwd'), PASSWORD_DEFAULT));
        $user->setTokenPassword('');
        (new UserManager())->save($user);

        Auth::saveUser($user);

        return Router::redirect('home');
    }
}