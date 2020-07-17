<?php

namespace App\Controllers;

use App\Core\View;
use App\Core\Http\Request;
use App\Mails\ContactMail;
use App\Core\Http\Response;
use App\Core\Routing\Router;
use App\Core\Controller\Controller;
use App\Managers\ConfigurationManager;
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
        $request->setInputPrefix('createContactForm_');
        
        $form = $response->createForm(CreateContactForm::class);
        
        if (false === $form->handle($request)) {
            return $response->render("contact", "main", ["createContactForm" => $form]);
        } 
        
        $configuration = current((new ConfigurationManager)
        ->findBy(['libelle' => 'email']));

        $body = "Vous avez reçu un mail de la part de : " . $request->get('email');
        $body .= "<br><br>";
        $body .= $request->get('body');

        ContactMail::sendMail($configuration->getInfo(), $request->get('object'), $body);
        
        Router::redirect('home');
    }
}