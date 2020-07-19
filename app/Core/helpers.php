<?php

use App\Core\Auth;
use App\Core\Builder\QueryBuilder;
use App\Core\Routing\Route;
use App\Core\Routing\Router;
use App\Managers\ConfigurationManager;
use App\Core\Csrf;
use App\Managers\ImageManager;
use App\Managers\NavbarElementManager;
use App\Models\Configuration;
use App\Models\User;

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

function getSliderImages(): array
{
    $toReturn = [];
    $imageManager = new ImageManager();
    $sliderConfigurations = (new QueryBuilder())
        ->select('*')
        ->from('configurations', 'c')
        ->where('libelle LIKE \'slider_%\'')
        ->getQuery()
        ->getArrayResult(Configuration::class);
    foreach ($sliderConfigurations as $sliderConfiguration)
    {
        $sliderImage = $imageManager->find((int) $sliderConfiguration->getInfo());
        $toReturn[] = url('img/uploadedImages/' . $sliderImage->getPath());
    }

    return $toReturn;
}

function getLogoPath(): string
{
    if (! defined('INSTALLATION_SUCCESS') || INSTALLATION_SUCCESS !== 1)
        return url('img/uploadedImages/logo.png');

    return getImagePathFromConfiguration('logo');
}

function getFaviconPath(): string
{
    if (! defined('INSTALLATION_SUCCESS') || INSTALLATION_SUCCESS !== 1)
        return url('img/uploadedImages/favicon.ico');

    return getImagePathFromConfiguration('favicon');
}

function getBannerPath(): string
{
    if (! defined('INSTALLATION_SUCCESS') || INSTALLATION_SUCCESS !== 1)
        return url('img/uploadedImages/banner.jpg');

    return getImagePathFromConfiguration('banner');
}

function getImagePathFromConfiguration(string $libelle): string
{
    $configuration = current((new ConfigurationManager())->findBy(['libelle' => $libelle]));
    $image = (new ImageManager())->find((int) $configuration->getInfo());

    return url('img/uploadedImages/' . $image->getPath());
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

function getAuth(): ?User
{
    return Auth::getUser();
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
