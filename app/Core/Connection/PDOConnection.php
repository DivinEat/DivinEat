<?php
namespace App\Core\Connection;

use App\Core\Connection\PDOSingleton;

class PDOConnection implements BDDInterface
{
    protected \PDO $pdo;

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


    public function query(string $query, array $parameters = null): PDOResult
    {
        $queryPrepared = $this->pdo->prepare($query);

        if ($parameters !== null)
        {
            $type = [
                'boolean' => \PDO::PARAM_BOOL,
                'integer' => \PDO::PARAM_INT,
                'string' => \PDO::PARAM_STR
            ];
            foreach ($parameters as $key => $value)
            {
                $queryPrepared->bindValue($key, $value, $type[gettype($value)]);
            }
        }

        $queryPrepared->execute();

        return new PDOResult($queryPrepared);
    }

    public function lastInsertId($name = null): string
    {
        return $this->pdo->lastInsertId($name = null);
    }
}