<?php
namespace App\Core\Command;

class Receiver
{
    private $enableDate = false;
    private $output = [];

    public function write(string $str): void
    {
        if($this->enableDate){
            $str = "[".date("Y-m-d H:i")."]".$str; 
        }

        $this->output[] = $str;
    }

    public function getOutput(): string
    {
        return join("\n", $this->output)."\n";
    }
    
    public function printOutPut(): void
    {
        $out = fopen("php://output", "w");
        fputs($out, $this->getOutput());
        fclose($out);
    }

    public function enableDate(): self
    {
        $this->enableDate = true;

        return $this;
    }

    public function disableDate(): self
    {
        $this->enableDate = false;

        return $this;
    }
}