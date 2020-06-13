<?php

namespace App\Core\Connection;

use App\Core\Connection\ResultInterface;
use PDOStatement;
use App\Controllers\ErrorController;
use App\Core\PDOSingleton;

class PDOResult implements ResultInterface
{
    protected $statement;
    protected $pdo;

    public function __construct(PDOStatement $statement, PDOSingleton $pdo)
    {
        $this->statement = $statement;
        $this->pdo = $pdo;
    }

    public function getArrayResult(string $class = null): array
    {
        $result = $this->statement->fetchAll($this->pdo::FETCH_ASSOC);

        if ($class) {
            $results = [];

            foreach($result as $value) {
                array_push($results, (new $class())->hydrate($value));
            }
            return $results;
        }

        return $result;
    }

    public function getOneOrNullResult(string $class = null)
    {
        $result = $this->statement->fetch($this->pdo::FETCH_ASSOC);

        if ($class)
            return (new $class())->hydrate($result);
        
        return $result;
    }

    public function getValueResult()
    {
        return $this->statement->fetchColumn();
    }
}