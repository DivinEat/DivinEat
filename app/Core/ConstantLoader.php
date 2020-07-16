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
        if ($this->checkFilesEnv())
        {
            $this->getContentFiles();
            $this->load();
        }
    }

    public function checkFilesEnv()
    {
        return file_exists($this->path."env");
    }

    public function getContentFiles()
    {
        $this->text .= "\n".file_get_contents($this->path."env");
    }

    public function getConstantAsArray(): array
    {
        $toReturns = [];
        foreach (explode("\n", $this->text) as $line)
        {
            $data = explode("=", $line);
            if (isset($data[0]) && isset($data[1]))
                $toReturns[$data[0]] = trim($data[1]);
        }

        return $toReturns;
    }

    public function load()
    {
        foreach (explode("\n", $this->text) as $line) {
            $data = explode("=", $line);
            if (isset($data[0]) && isset($data[1]))
            {
                define($data[0], trim($data[1]));
            }
        }
    }
}