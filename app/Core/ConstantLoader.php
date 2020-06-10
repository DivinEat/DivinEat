<?php
namespace App\Core;

class ConstantLoader
{
    public $extend;
    public $text;
    public $path = ROOT."/.";

    public function __construct($extend = "dev")
    {
        $this->extend = $extend;
        $this->checkFilesEnv();
        $this->getContentFiles();
        $this->load();
    }

    public function checkFilesEnv()
    {
        if (!file_exists($this->path."env")) {
            die("Le fichier .env n'existe pas");
        }
        if (!file_exists($this->path.$this->extend)) {
            die("Le fichier .".$this->extend." n'existe pas");
        }
    }

    public function getContentFiles()
    {
        $this->text = file_get_contents($this->path.$this->extend);
        $this->text .= "\n".file_get_contents($this->path."env");
    }

    public function load()
    {
        $lines = explode("\n", $this->text);
        foreach ($lines as $line) {
            $data = explode("=", $line);
            if (!defined($data[0]) && isset($data[1])) {
                define($data[0], trim($data[1]));
            }
        }
    }
}