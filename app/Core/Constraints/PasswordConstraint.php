<?php

namespace App\Core\Constraints;


class PasswordConstraint implements ConstraintInterface
{
    protected $errors = [];

    public function __construct()
    {
    }

    public function isValid(string $value): bool
    {
        $this->errors = [];

        // if (preg_match("/^(?=.*\d)(?=.*[-)(!'\"6&§@#:\/;,?.=+*\$€£ù%^¨éèçà])(?=.*[a-z])(?=.*[A-Z])$/", $value) == false)
        //     $this->errors[] = "Le format du mot de passe n'est pas bon.";

        return (0 == count($this->errors));
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
