<?php

namespace App\Core\Constraints;

class FileConstraint implements ConstraintInterface
{
    protected $errors = [];

    public function __construct()
    {
    }

    public function isValid(string $value, string $elementName): bool
    {
        $type = explode(".", $value);
        $type = ucwords(end($type));

        if($type === 'JPG' || $type === 'PNG' || $type === 'JPEG'){
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
