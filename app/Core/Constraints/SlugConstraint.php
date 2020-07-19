<?php

namespace App\Core\Constraints;


class SlugConstraint implements ConstraintInterface
{
    protected array $errors = [];

    public function isValid(string $value, string $elementName): bool
    {
        $this->errors = [];

        if (preg_match("/^[a-z\-]+$/", $value) == false)
            $this->errors[] = "Le format du slug n'est pas bon.";

        return (0 == count($this->errors));
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}