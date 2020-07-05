<?php

namespace App\Controllers\Auth;

use App\Core\Controller\Controller;
use App\Core\Http\Request;
use App\Core\Http\Response;
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
        echo "forgotPassword";
    }
}