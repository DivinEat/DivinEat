<?php

namespace App\Core\Constraints;


class HoraireConstraint implements ConstraintInterface
{
    protected $errors = [];

    public function __construct()
    {
    }

    public function isValid(string $value, string $elementName): bool
    {
        $this->errors = [];

        if (preg_match("/^([0-1][0-9]|2[0-3])H[0-5][0-9] - ([0-1][0-9]|2[0-3])H[0-5][0-9]$/", $value) == false)
            $this->errors[] = "Le format de l'horaire n'est pas bon : hhHmm - hhHmm";

        return (0 == count($this->errors));
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
