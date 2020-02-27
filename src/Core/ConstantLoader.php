<?php

namespace Src\Core;

class ConstantLoader
{
    public function __construct()
    {
        if ($this->isEnvFileExist())
            $this->createConstantFromEnvFile();
    }

    protected function isEnvFileExist(): bool
    {
        if (!file_exists(ROOT.DS.'.env'))
            throw new \Exception('Aucun fichier d\'environement détecté.');

        return true;
    }

    protected function createConstantFromEnvFile(): void
    {
        array_map(function ($line) {
            $explodedLine = explode('=', $line);

            if (isset($explodedLine[0], $explodedLine[1])
                && !defined($explodedLine[0], $explodedLine[1]))
                define($explodedLine[0], $explodedLine[1]);
        },explode('\n', file_get_contents(ROOT.DS.'.env')));
    }
}