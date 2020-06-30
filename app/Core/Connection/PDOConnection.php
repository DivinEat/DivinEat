<?php
namespace App\Core\Connection;

use App\Core\Connection\PDOSingleton;

class PDOConnection implements BDDInterface
{
    protected $pdo;

    public function __construct()
    {
        $this->connect();
    }

    public function connect() 
    {
        try {
            $this->pdo = PDOSingleton::getInstance();
        } catch (\Throwable $e) {
            die("Erreur SQL : ".$e->getMessage());
        }
    }


    public function query(string $query, array $parameters = null)
    {
        if ($parameters) {
            $queryPrepared = $this->pdo->prepare($query);

            $queryPrepared->execute($parameters);

            return new PDOResult($queryPrepared);
        } else {
            $queryPrepared = $this->pdo->prepare($query);
            $queryPrepared->execute();

            return new PDOResult($queryPrepared);
        }
    }

    public function lastInsertId(): ?int
    {
        return $this->pdo->lastInsertId();
    }
}