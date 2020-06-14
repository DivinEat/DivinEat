<?php

namespace App\Core;

class View
{
    private string $templatePath;
    private string $viewPath;
    private array $data = [];


    public function __construct(string $viewName, string $templateName = "admin")
    {
        $this->setTemplatePath($templateName);
        $this->setViewPath($viewName);
    }


    public function setTemplatePath(string $templateName): void
    {
        $this->templatePath =
            ROOT . "/ressources/views/layouts/" .
            str_replace('.', DIRECTORY_SEPARATOR, strtolower(trim($templateName)))
            . ".php";

        if (!file_exists($this->templatePath))
            throw new \Exception("Impossible d'include le template.");
    }


    public function setViewPath(string $viewName): void
    {
        $this->viewPath =
            ROOT . "/ressources/views/" .
            str_replace('.', DIRECTORY_SEPARATOR, strtolower(trim($viewName)))
            .".php";

        if (!file_exists($this->viewPath))
            throw new \Exception("Impossible d'include la vue.");
    }


    public function assign($key, $value) :void 
    {
        $this->data[$key] = $value;
    }

    public function addModal(string $modal, $data, $infos = NULL): void
    {
        $modal =
            ROOT . "/ressources/views/modals/".
            str_replace('.', DIRECTORY_SEPARATOR, strtolower(trim($modal)))
            . ".php";

        if (!file_exists($modal))
            throw new \Exception("Impossible d'include le modal.");

        include $modal;
    }


    public function __destruct()
    {
        extract($this->data);

        include $this->templatePath;
    }
}