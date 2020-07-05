<?php

namespace App\Controllers;

use App\Core\Controller\Controller;
use App\Core\Routing\Router;
use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\View;
use App\Forms\Contact\CreateContactForm;

class ContactController extends Controller
{
    public function index(Request $request, Response $response)
    {
        $form = $response->createForm(CreateContactForm::class);

        $response->render("contact", "main", ["createContactForm" => $form]);
    }

    public function store(Request $request, Response $response, array $args)
    {
        $data = $_POST;

        Router::redirect('home');
    }
}