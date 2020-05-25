<?php

function url(string $path): string
{
    $url = $_SERVER['HTTP_HOST'] . '/' . $path;
    if (!preg_match('/^http:\/\//', $url))
        $url = 'http://' . $url;

    return $url;
}