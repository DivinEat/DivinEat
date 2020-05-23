<?php

namespace App\Core\Connection;

use App\Core\Connection\BDDInterface;
use App\Core\Connection\PDOResult;
use App\Core\PDOSingleton;

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
        } catch (Exception $e) {
            throw new BDDException('Erreur de connexion à la base de données : ' . $e->getMessage());
        }
    }

    public function query(string $query, array $params = null)
    {
        if(isset($params)){
            $queryPrepared = $this->pdo->prepare($query);
            $queryPrepared->execute($params);
        } else {
            $queryPrepared = $this->pdo->prepare($query);
            $queryPrepared->execute();
        }

        return new PDOResult($queryPrepared, $this->pdo);
    }
}