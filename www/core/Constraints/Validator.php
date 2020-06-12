<?php

namespace App\core\Constraints;

class Validator
{
    public function checkConstraint(ConstraintInterface $constraint, string $value): ?array
    {
        if($constraint->isValid($value))
        {
            return null;
        }

        return $constraint->getErrors();
    }
}