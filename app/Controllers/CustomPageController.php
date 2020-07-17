<?php

namespace App\Controllers;

use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Managers\PageManager;
use App\Core\Controller\Controller;

class CustomPageController extends Controller
{
    public function display(Request $request, Response $response, array $args)
    {
        $page = (new PageManager())->findAll()[0];
        $content = $page->getData();

        return $response->render('customPage', 'main', ['page' => $content]);
    }
}
