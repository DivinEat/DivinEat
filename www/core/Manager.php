<?php

namespace App\Core;

use App\Core\PDOSingleton;
use App\Core\Connection\PDOConnection;

class Manager
{
    private $table;
    private $connection;
    protected $class;

    public function __construct(string $class, string $table, BDDInterface $connection = null)
    {
        //SINGLETON
        try {
            $this->connection = PDOSingleton::getInstance();
        } catch (Exception $e) {
            echo "Erreur SQL : ".$e->getMessage();
        }

        $this->class = $class;
        $this->table = DB_PREFIXE.$table;

        $this->connection = $connection;
        if(NULL === $connection)
            $this->connection = new PDOConnection();
    }

    public function save($objectToSave)
    {
        $objectArray = $objectToSave->__toArray();
        $columns = array_keys($objectArray);

        $params = array_combine(
            array_map(function($key) {return ':'.$key; }, $columns), $objectArray
        );

        if (!is_numeric($objectToSave->getId())) {

            $query = "INSERT INTO ".$this->table." (".implode(",", $columns).") VALUES (:".implode(",:", $columns).");";

        } else {

            foreach ($columns as $column) {
                $sqlUpdate[] = $column."=:".$column;
            }

            $query = "UPDATE ".$this->table." SET ".implode(",", $sqlUpdate)." WHERE id=:id;";
        }

        $this->connection->query($query, $params);
    }

    public function find(int $id): ?\App\Core\Model
    {
        $query = "select * from  $this->table where id = :id";

        $result = $this->connection->query($query, [':id' => $id]);

        $row = $result->getOneOrNullResult();

        if($row){
            $object = new $this->class();
            return $object->hydrate($row);
        } else {
            return null;
        }
    }

    public function findBy(array $params, array $order = null): array
    {
        $results = array();

        $query = "select * from $this->table where ";

        foreach($params as $key => $value) {
            if(is_string($value)) {
                $comparator = 'like';
            } else {
                $comparator = '=';
            }

            $query .= "$key $comparator :$key and";
            
            $params[":$key"] = $value;
            unset($params[$key]);
        }

        $query = rtrim($query, 'and');

        if($order) {
            $query .= "order by " . key($order) . " " . $order[key($order)];
        }
        
        $result = $this->connection->query($query, $params);
        $rows = $result->getArrayResult();

        foreach($rows as $row) {
            $object = new $this->class();
            array_push($results, $object->hydrate($row));
        }

        return $results;
    }

    public function count(array $params): int
    {
        $query = "SELECT COUNT(*) FROM $this->table where ";
 
        foreach($params as $key => $value){
            if(is_string($value)){
                $comparator = 'LIKE';
            } else {
                $comparator = "=";
            }
 
            $query .= " $key $comparator :$key and";
 
            $params[":$key"] = $value;
            unset($params[$key]);
        }
 
        $query = rtrim($query, "and");
 
        $result = $this->connection->query($query, $params);
        return $result->getValueResult();
    }

    public function findAll(): array 
    {
        $results = array();

        $query = "select * from $this->table";

        $result = $this->connection->query($query);

        $rows = $result->getArrayResult();

        foreach($rows as $row) {
            $object = new $this->class();
            array_push($results, $object->hydrate($row));
        }

        return $results;
    }

    public function delete(int $id): bool
    {
        $query = "delete from $this->table where id = :id";

        $result = $this->connection->query($query, [':id' => $id]);
    
        return true;
    }
}
