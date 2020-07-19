<?php

namespace App\Core\Constraints;

class FaviconConstraint implements ConstraintInterface
{
    protected $errors = [];

    public function __construct()
    {
    }

    public function isValid(string $value, string $elementName): bool
    {
        $ext = pathinfo($value, PATHINFO_EXTENSION);
        $ext = strtoupper($ext);

        if($ext === 'ICO'){
            return true;
        }

        $this->errors[] = "Le format du fichier est invalide !";

        return false;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
