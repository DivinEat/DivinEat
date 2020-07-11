<?php

namespace App\Core\Constraints;


class UniqueConstraint implements ConstraintInterface
{
    protected $select;
    protected $message;
    protected $ignoreId;
    protected $errors = [];

    // mettre un message par défaut si minMessage et maxMessage sont nuls, et setter les valeurs
    public function __construct(string $select, string $message, $ignoreId = null)
    {
        $this->select = $select;
        $this->message = $message;
        $this->ignoreId = $ignoreId;
    }

    public function isValid(string $value, string $elementName): bool
    {
        $this->errors = [];

        // select = users.email
        // ignore = Auth::getUser()->getId()

        $select = explode(".", $this->select);

        $table = $select[0];
        if(substr($table, -1) == "s")
            rtrim($table)
        
        $managerName = ucfirst($table) . "Manager()";

        $results = (new $managerName)->findBy([$select[1] => $value]);

        foreach($results as $result){
            if($result->getId() !== $this->ignoreId){
                
            }
        }



        

        if(strlen($value) < $this->min)
            $this->errors[] = $this->minMessage;

        return (0 == count($this->errors));
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}