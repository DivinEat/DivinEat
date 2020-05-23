<?php

namespace App\Controllers;

use App\Core\View;

class ErrorController 
{
    public function __construct()
    {

    }

    public function displayErrorAction()
    {
        $message = $_GET['message'] ?? 'Pas de message d\'erreur';
        $errorView = new View("error", "error");
        $errorView->assign("errorMessage", $message);
    }
}

