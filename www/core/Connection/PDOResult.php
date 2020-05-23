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

    public function getArrayResult(): array
    {
        return $this->statement->fetchAll($this->pdo::FETCH_ASSOC);
    }

    public function getOneOrNullResult(): ?array 
    {
        $result = $this->statement->fetch($this->pdo::FETCH_ASSOC);

        if (!$result) {
            return null;
        } else {
            return $result;
        }
    }

    public function getValueResult()
    {
        return $this->statement->fetchColumn();
    }
}