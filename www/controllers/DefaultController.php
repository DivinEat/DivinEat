<?php
namespace App\controllers;
use App\core\View;

namespace App\controllers;
use App\core\View;

class DefaultController
{
    public function defaultAction()
    {

        //Récupéré depuis la bdd
        $firstname = "Yves";
        
        //View dashboard sur le template back
        $myView = new View("dashboard");
        $myView->assign("firstname", $firstname);
    }
}
