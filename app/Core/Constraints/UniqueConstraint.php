<?php

namespace App\Core\Constraints;


class UniqueConstraint implements ConstraintInterface
{
    protected string $select;
    protected string $message;
    protected ?int $ignoreId;
    protected array $errors = [];

    public function __construct(string $select, string $message, $ignoreId = null)
    {
        $this->select = $select;
        $this->message = $message;
        $this->ignoreId = $ignoreId;
    }

    public function isValid(string $value, string $elementName): bool
    {
        $explodedSelect = explode(".", $this->select);
        if (! $this->isExistWithIgnoreId($value, $explodedSelect[0], $explodedSelect[1]))
            return true;

        $this->errors[] = $this->message;

        return false;
    }

    public function isExistWithIgnoreId(string $value, string $tableName, string $columnName): bool
    {
        if(substr($tableName, -1) === "s")
            rtrim($tableName);

        $managerName = ucfirst($tableName) . "Manager()";

        $results = (new $managerName)->findBy([$columnName => $value]);

        foreach($results as $result){
            if(null === $this->ignoreId ||$result->getId() !== $this->ignoreId)
                return true;
        }

        return false;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}