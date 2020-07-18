<?php

namespace App\Core\Constraints;


class PasswordConstraint implements ConstraintInterface
{
    protected $errors = [];

    public function __construct()
    {
    }

    public function isValid(string $value, string $elementName): bool
    {
        $this->errors = [];

        if(! empty($value)){
            if (preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[@&é\"'(§\\\<>|è!çà)|è_!çà)[\]\-#°^¨$*%ù=+:\/;.,?])([@&é\"'(§\\\<>|è!çà)|è!çà)[\]\-#°^¨$*%ù=+:\/;.,?\w]){8,16}$/", $value) == false)
                $this->errors[] = "Le format du mot de passe n'est pas bon.";
        }

        return (0 == count($this->errors));
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
