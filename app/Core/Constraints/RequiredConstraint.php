<?php

namespace App\Core\Constraints;


class RequiredConstraint implements ConstraintInterface
{
    protected $errors = [];

    public function __construct()
    {
    }

    /**
     * $elementName correspond au label du champ s'il est renseigné, sinon à l'attribut name du champ
     */
    public function isValid(string $value, string $elementName): bool
    {
        $this->errors = [];

        if ($value === null || $value === "")
            $this->errors[] = "Le champ <b><i>$elementName</i></b> doit être renseingé";

        return (0 == count($this->errors));
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}