<?php

namespace App\Core\Middleware;

use App\Core\Http\Request;

interface Handler
{
    public function handle(Request $request, callable $handler);
}