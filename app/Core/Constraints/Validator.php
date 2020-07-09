<?php

namespace App\Core\Constraints;

use App\Core\Constraints\ConstraintInterface;

class Validator
{
    public function checkConstraint(ConstraintInterface $constraint, string $value, string $elementName): ?array
    {
        if($constraint->isValid($value, $elementName))
            return null;

        return $constraint->getErrors();
    }
}