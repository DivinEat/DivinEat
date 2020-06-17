<?php

namespace App\Controllers;

use App\Core\Controller\Controller;
use App\Core\Routing\Router;
use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\View;

class ContactController extends Controller
{
    public function index(Request $request, Response $response)
    {
        $configFormContact = $this->getContactForm();

        $myView = new View("contact", "main");
        $myView->assign("configFormContact", $configFormContact);

    }

    public function store(Request $request, Response $response, array $args)
    {
        $data = $_POST;

        Router::redirect('home');
    }

    public function getContactForm(){
        return [
            "config"=>[
                "method"=>"POST", 
                "action"=> Router::getRouteByName('contact.store'),
                "class"=>"admin-form width-100",
                "id"=>"formLoginUser",
                "submit"=>[
                    "btn btn-account btn-account-blue margin-top-50"=>"<i class='fa fa-paper-plane'></i>Envoyer"
                ]
            ],

            "fields"=>[
                "email"=>[
                    "type"=>"email",
                    "placeholder"=>"&#xf2be;  Adresse Email",
                    "class"=>"form-control form-control-user",
                    "id"=>"",
                    "required"=>true,
                    "uniq"=>["table"=>"users","column"=>"email"],
                    "errorMsg"=>"Le format de votre email ne correspond pas"
                ],
                "objet"=>[
                    "type"=>"text",
                    "placeholder"=>"&#xf0e5;  Objet",
                    "class"=>"form-control form-control-user",
                    "id"=>"",
                    "required"=>true
                ],
                "text"=>[
                    "type"=>"textarea",
                    "placeholder"=>"&#xf0e5;  Ecrire ici",
                    "class"=>"form-control form-control-textarea form-control-user",
                    "id"=>"",
                    "required"=>true,
                    "errorMsg"=>"Votre mot de passe doit faire entre 6 et 20 caractères avec une minuscule et une majuscule"
                ]
            ]
        ];
    }
}