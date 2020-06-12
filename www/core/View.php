<?php
namespace App\core;

class View
{
    private $template;
    private $view;
    private $data = [];


    public function __construct($view, $template="back")
    {
        $this->setTemplate($template);
        $this->setView($view);
    }


    public function setTemplate($t)
    {
        $this->template = strtolower(trim($t));

        if (!file_exists("views/templates/".$this->template.".tpl.php")) {
            die("Le template n'existe pas");
        }
    }


    public function setView($v)
    {
        $this->view = strtolower(trim($v));

        if (!file_exists("views/".$this->view.".view.php")) {
            throw new \Exception("La vue views/".$this->view.".view.php n'existe pas");
        }
    }


    public function assign($key, $value)
    {
        $this->data[$key] = $value;
    }

    public function formView(string $formName, string $formTemplate = "base")
    {
        if (!file_exists("views/forms/".$formTemplate.".view.php")) {
            die("Le template views/forms/".$formTemplate.".view.php de formulaire n'existe pas!!!");
        }

        $form = $this->data[$formName];// Objet Form

        include "views/forms/".$formTemplate.".view.php";
    }

    public function addModal($modal, $data)
    {
        if (!file_exists("views/modals/".$modal.".mod.php")) {
            throw new Exception("Le modal n'existe pas");
        }

        include "views/modals/".$modal.".mod.php";
    }


    public function __destruct()
    {
        extract($this->data);

        include "views/templates/".$this->template.".tpl.php" ;
    }
}
