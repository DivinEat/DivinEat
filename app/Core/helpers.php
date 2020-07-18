<?php

use App\Core\Routing\Route;
use App\Core\Routing\Router;
use App\Managers\ConfigurationManager;
use App\Core\Csrf;
use App\Managers\NavbarElementManager;

function url(string $path): string
{
    $url = $_SERVER['HTTP_HOST'] . '/' . $path;
    if (!preg_match('/^http:\/\//', $url))
        $url = 'http://' . $url;

    return $url;
}

function getConfig(string $libelle)
{
    $configManager = new ConfigurationManager();
    $config = $configManager->findBy(["libelle" => $libelle]);

    return current($config);
}

function csrfInput(): void
{
    echo "<input type='hidden' name='csrf_token' value='" . Csrf::getCsrfToken() . "'>";
}

function route(string $routeName, array $args = []): ?Route
{
    return Router::getRouteByName($routeName, $args);
}

function getCustomRoutes(): array 
{
    return (new NavbarElementManager())->findAll();
}

function snakeToCamelCase($string, $capitalizeFirstCharacter = false)
{

    $str = str_replace(' ', '', ucwords(str_replace('_', ' ', $string)));

    if (!$capitalizeFirstCharacter) {
        $str[0] = strtolower($str[0]);
    }

    return $str;
}

function dd($value)
{
    echo '<pre>';
    var_dump($value);
    die;
}

function br(): void
{
    echo '<br>';
}

function pre(): void
{
    echo '<pre>';
}
