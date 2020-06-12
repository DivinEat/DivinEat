<?php

namespace App\core\Constraints;

class Length implements ConstraintInterface
{
    protected $min;
    protected $max;
    protected $minMessage;
    protected $maxMessage;
    protected $errors = [];

    public function __construct(int $min, int $max, string $minMessage =null, string $maxMessage = null)
    {
        $this->min = $min;
        $this->max = $max;
        $this->minMessage = $minMessage;
        $this->maxMessage = $maxMessage;

        if(NULL == $this->minMessage)
            $this->minMessage = "Le champs doit contenir au moins $min caractères";

        if(NULL == $this->maxMessage)
            $this->minMessage = "Le champs doit contenir au plus $max caractères";
    }

    public function isValid(string $value): bool
    {
        $this->errors = [];

        if(strlen($value) < $this->min)
        {
            $this->errors[] = $this->minMessage;
        }

        if(strlen($value) > $this->max)
        {
            $this->errors[] = $this->maxMessage;
        }

        return (0 == count($this->errors));
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}