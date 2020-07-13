<?php

namespace App\Core\Constraints;

use App\Core\Csrf;


class CsrfConstraint implements ConstraintInterface
{
    protected $errors = [];

    public function __construct()
    {
    }

    public function isValid(string $value, string $elementName): bool
    {
        /*var_dump($value);
        var_dump($_SESSION["Csrf_token"]);
        die;*/

        if (Csrf::checkUserCsrfToken($value))
            return true;

        $this->errors[] = "Le formulaire n'est pas valide !";

        return false;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}