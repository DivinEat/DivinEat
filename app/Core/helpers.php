<?php
use App\Managers\ConfigurationManager;

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