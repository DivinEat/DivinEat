<?php

namespace App\Controllers;

use App\Core\View;

class ErrorController 
{
    public function __construct()
    {

    }

    public function displayErrorAction(string $error, string $message)
    {
        $errorView = new View($error, "error");
        $errorView->assign("errorMessage", $message);
    }
}

