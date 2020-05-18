<?php

namespace App\Controllers;

use App\Core\View;

class ErrorController 
{
    public function __construct()
    {

    }

    public function displayErrorAction(string $message = null)
    {
        $errorView = new View("error", "error");
        $errorView->assign("errorMessage", $message);
    }
}

