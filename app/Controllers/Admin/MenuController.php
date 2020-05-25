<?php

namespace App\Controllers\Admin;

use App\Core\Http\Request;
use App\Core\Http\Response;

class MenuController
{
    public function index(Request $request, Response $response)
    {
        echo 'index';
    }

    public function create(Request $request, Response $response)
    {
        echo 'create';
    }

    public function store(Request $request, Response $response)
    {
        echo 'store';
    }

    public function show(Request $request, Response $response, array $args)
    {
        echo 'show';
    }

    public function edit(Request $request, Response $response, array $args)
    {
        echo 'edit';
    }

    public function update(Request $request, Response $response, array $args)
    {
        echo 'update';
    }

    public function destroy(Request $request, Response $response, array $args)
    {
        echo 'destroy';
    }
}