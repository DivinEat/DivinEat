<?php

namespace App\Controllers\Admin;

use App\Core\Controller\Controller;
use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\View;

class ArticleController extends Controller
{
    public function index(Request $request, Response $response)
    {

    }

    public function create(Request $request, Response $response, array $args)
    {
        $myView = new View("admin.article.create", "admin");
    }

    public function edit(Request $request, Response $response, array $args)
    {

    }

    public function update(Request $request, Response $response, array $args)
    {

    }

    public function destroy(Request $request, Response $response, array $args)
    {

    }
}