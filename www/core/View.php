<?php

namespace App\Core;

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

        try {
            if (!file_exists("views/templates/".$this->template.".tpl.php")) {
                throw new Exception("Le template n'existe pas");
                // die("Le template n'existe pas");
            }
        } catch(Exception $e) {
            echo e.getMessage();
        }
    }


    public function setView($v)
    {
        $this->view = strtolower(trim($v));

        try {
            if (!file_exists("views/".$this->view.".view.php")) {
                throw new Exception("La vue n'existe pas");
                // die("La vue n'existe pas");
            }
        } catch(Exception $e) {
            echo e.getMessage();
        }
    }


    public function assign($key, $value)
    {
        $this->data[$key] = $value;
    }

    // $this->addModal("carousel", $data);
    public function addModal($modal, $data)
    {
        try {
            if (!file_exists("views/modals/".$modal.".mod.php")) {
                throw new Exception("Le modal n'existe pas!!!");
                // die("Le modal n'existe pas!!!");
            }
        } catch(Exception $e) {
            echo e.getMessage();
        }

        include "views/modals/".$modal.".mod.php";
    }


    public function __destruct()
    {
        // $this->data = ["firstname"=>"yves"];
        extract($this->data);
        //$firstname = "yves";

        include "views/templates/".$this->template.".tpl.php" ;
    }
}
