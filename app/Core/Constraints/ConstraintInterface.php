<?php

namespace App\Core\Constraints;

interface ConstraintInterface
{
    public function isValid(string $value, string $elementName): bool;

    public function getErrors(): array;
}