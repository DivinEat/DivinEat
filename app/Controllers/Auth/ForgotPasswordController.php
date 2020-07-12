<?php

namespace App\Controllers\Auth;

use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\Routing\Router;
use App\Managers\UserManager;
use App\Core\Controller\Controller;
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
        
        if (false === $form->handle()) {
            return $response->render("auth.forgot_password", "account", ["forgotPasswordForm" => $form]);
        }

        $user = current((new UserManager())->findBy(['email' => $request->get('email')]));

        if (false !== $user)
            // Envoyer le mail

        return Router::redirect('auth.show-forgot-password');
    }
}