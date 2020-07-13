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

        foreach($data as $elementName => $element) {
            $data[explode("_", $elementName)[1]] = $data[$elementName];
            unset($data[$elementName]);
        }
        
        $form = $response->createForm(CreateContactForm::class);
        
        if (false === $form->handle($request)) {
            $response->render("contact", "main", ["createContactForm" => $form]);
        } else {      
            //PHP MAILER CODE
            
            Router::redirect('home');
        }
    }
}