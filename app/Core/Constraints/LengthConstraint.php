<?php

namespace App\Core\Constraints;


class LengthConstraint implements ConstraintInterface
{
    protected $min;
    protected $max;
    protected $minMessage;
    protected $maxMessage;
    protected $errors = [];

    // mettre un message par défaut si minMessage et maxMessage sont nuls, et setter les valeurs
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

    // vérifie que la valeur est entre min et max
    // sinon on ajoute dans errors l'erreur associé
    public function isValid(string $value, string $elementName): bool
    {
        $this->errors = [];

        if(strlen($value) < $this->min)
            $this->errors[] = $this->minMessage;

        if(strlen($value) > $this->max)
            $this->errors[] = $this->maxMessage;

        return (0 == count($this->errors));
    }

    // On retourne le tableau d'erreurs, vide si pas d'erreur
    public function getErrors(): array
    {
        return $this->errors;
    }
}