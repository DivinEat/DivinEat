<?php

namespace App\Core\Constraints;

interface ConstraintInterface
{
    public function isValid(string $value): bool;

    public function getErrors(): array;
}