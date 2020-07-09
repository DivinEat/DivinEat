<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller\Controller;
use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\Routing\Router;
use App\Forms\User\UpdateUserForm;

class UserController extends Controller
{
    public function index(Request $request, Response $response, array $args)
    {
        $form = $response->createForm(UpdateUserForm::class, Auth::getUser());

        $response->render("profile", "main", ["updateUserForm" => $form]);
    }
}