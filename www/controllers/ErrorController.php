<?php

namespace App\controllers;

use App\core\View;

class ErrorController 
{
    public function __construct(){}

    public function urlNotExist(){
        $errorView = new View("error", "error");
        $errorView->assign("errorMessage", "L'url n'existe pas : Erreur 404");
    }

    public function actionNotExist(){
        $errorView = new View("error", "error");
        $errorView->assign("errorMessage", "L'action' n'existe pas");
    }

    public function controllerNotExist(){
        $errorView = new View("error", "error");
        $errorView->assign("errorMessage", "Le fichier controller n'existe pas");
    }

    public function otherErrors($message){
        $errorView = new View("error", "error");
        $errorView->assign("errorMessage", $message);
    }
}