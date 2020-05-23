<?php
namespace App\core\Command;

interface CommandInterface
{
    public function execute();

    public function setArgs(array $args);
}