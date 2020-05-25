<?php

namespace App\Core;

class Cache
{
    public static function remember(string $cacheName, callable $closure)
    {
        if (!empty($cacheName))
            return $closure();
    }
}