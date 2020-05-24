<?php

namespace App\Core\Middleware;

use App\Core\Http\Request;
use App\Core\Http\Response;

interface Handler
{
    public function run(Request $request, Response $response);

    public function handle(Request $request, Response $response, callable $handler);
}