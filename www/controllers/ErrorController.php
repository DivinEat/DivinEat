<?php

namespace App\controllers;

use App\core\View;

class ErrorController 
{
    public function __construct()
    {

    }

    public function defaultAction(string $error, string $message)
    {
        $errorView = new View($error, "error");
        $errorView->assign("errorMessage", $message);
    }
}