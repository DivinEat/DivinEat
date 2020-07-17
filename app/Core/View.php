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

    public function getAdditionalJs(): void
    {
        if (preg_match('/ressources\/views\/(.*)/', $this->viewPath, $match))
            if (file_exists(ROOT . '/ressources/views/additional_js/' . $match[1]))
                include ROOT . '/ressources/views/additional_js/' . $match[1];
    }

    //Methode permettant d'afficher un formulaire en lui passant le nom dans data (ici formProfile)
    //Et affichant la vue
    public function formView(string $formName, string $formDir, string $formTemplate = "base")
    {
        $formPath = ucFirst($formDir) . "/" . $formTemplate;
        $formPath = ROOT . "/ressources/" . "/views/forms/".$formPath.".php";

        if (!file_exists($formPath)) {
            die("Le template de formulaire <i>{$formPath}</i> n'existe pas!!!");
        }

        $form = $this->data[$formName];

        include ROOT . "/ressources/views/layouts/forms/form.php";
    }


    public function __destruct()
    {
        extract($this->data);

        include $this->templatePath;
    }
}