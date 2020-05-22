<?php

namespace App\Core;

use App\Core\PDOSingleton;

class Manager
{
    private $table;
    private $pdo;
    private $class;

    public function __construct(string $class, string $table)
    {
        //SINGLETON
        try {
            $this->pdo = PDOSingleton::getInstance();
        } catch (Exception $e) {
            echo "Erreur SQL : ".$e->getMessage();
        }

        $this->class = $class;
        $this->table = DB_PREFIXE.$table;
    }

    public function sql($sql, $parameters = null)
    {
        if(isset($parameters)){
            $queryPrepared = $this->pdo->prepare($sql);
            $queryPrepared->execute($parameters);
        } else {
            $queryPrepared = $this->pdo->prepare($sql);
            $queryPrepared->execute();
        }
        return $queryPrepared;
    }

    public function save($objectToSave)
    {
        $objectArray = $objectToSave->__toArray();
        $columns = array_keys($objectArray);

        $params = array_combine(
            array_map(function($key) {return ':'.$key; }, $columns), $objectArray
        );

        if (!is_numeric($objectToSave->getId())) {

            $sql = "INSERT INTO ".$this->table." (".implode(",", $columns).") VALUES (:".implode(",:", $columns).");";

        } else {

            foreach ($columns as $column) {
                $sqlUpdate[] = $column."=:".$column;
            }

            $sql = "UPDATE ".$this->table." SET ".implode(",", $sqlUpdate)." WHERE id=:id;";
        }

        $this->sql($sql, $params);
    }

    public function find(int $id): ?\App\Core\Model
    {
        $sql = "select * from  $this->table wherez id = :id";

        $result = $this->sql($sql, [':id' => $id]);

        $row = $result->fetch();

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

        $sql = "select * from $this->table where ";

        foreach($params as $key => $value) {
            if(is_string($value)) {
                $comparator = 'like';
            } else {
                $comparator = '=';
            }

            $sql .= "$key $comparator :$key and";
            
            $params[":$key"] = $value;
            unset($params[$key]);
        }

        $sql = rtrim($sql, 'and');

        if($order) {
            $sql .= "order by " . key($order) . " " . $order[key($order)];
        }
        
        $result = $this->sql($sql, $params);
        $rows = $result->fetchAll();

        foreach($rows as $row) {
            $object = new $this->class();
            array_push($results, $object->hydrate($row));
        }

        return $results;
    }

    public function count(array $params): int
    {
        $sql = "SELECT COUNT(*) FROM $this->table where ";
 
        foreach($params as $key => $value){
            if(is_string($value)){
                $comparator = 'LIKE';
            } else {
                $comparator = "=";
            }
 
            $sql .= " $key $comparator :$key and";
 
            $params[":$key"] = $value;
            unset($params[$key]);
        }
 
        $sql = rtrim($sql, "and");
 
        $result = $this->sql($sql, $params);
        return $result->fetchColumn();
    }

    public function findAll(): array 
    {
        $results = array();

        $sql = "select * from $this->table";

        $result = $this->sql($sql);

        $rows = $result->fetchAll($this->pdo::FETCH_ASSOC);

        foreach($rows as $row) {
            $object = new $this->class();
            array_push($results, $object->hydrate($row));
        }

        return $results;
    }

    public function delete(int $id): bool
    {
        $sql = "delete from $this->table where id = :id";

        $result = $this->sql($sql, [':id' => $id]);
    
        return true;
    }
}
