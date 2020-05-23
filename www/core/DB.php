<?php
namespace App\core;
//use App\core\PDOSingleton;
use App\core\Connection\BDDInterface;
use App\core\Connection\PDOConnection;

class DB
{
    private $table;
    //private $pdo;
    private $connection;
    protected $class;

    public function __construct(string $class, string $table, BDDInterface $connection = null)
    {
        $this->class = $class;
        $this->table =  DB_PREFIXE.$table;

        $this->connection = $connection;
        if(NULL === $connection){
            $this->connection = new PDOConnection();
        }

        /*try {
            $this->pdo = PDOSingleton::getInstance();
        } catch (Exception $e) {
            die("Erreur SQL : ".$e->getMessage());
        }*/
    }

    public function save($objectToSave)
    {
        $objectArray = $objectToSave->__toArray();

        $columnsData = array_values($objectArray);
        $columns = array_keys($objectArray);

        $params = array_combine(array_map(function($k){return ":".$k;},array_keys($objectArray)),$objectArray);

        if (!is_numeric($objectToSave->getId())) {
            array_shift($columns);
            array_shift($params);
            //INSERT
            $sql = "INSERT INTO ".$this->table." (".implode(",", $columns).") VALUES (:".implode(",:", $columns).");";
        } else {
            //UPDATE
            foreach ($columns as $column) {
                $sqlUpdate[] = $column."=:".$column;
            }
            $sql = "UPDATE ".$this->table." SET ".implode(",", $sqlUpdate)." WHERE id=:id;";
        }

        $this->connection->query($sql, $params);

        //$this->sql($sql, $params);
    }

    public function find(int $id): ?\App\models\Model
    {
        $sql = "SELECT * FROM $this->table WHERE id = :id";

        $result = $this->connection->query($sql, [':id' => $id]);
        $row = $result->getOneOrNullResult();

        /*$result = $this->sql($sql, [':id' => $id]);
        $row = $result->fetch();*/

        if($row){
            $object = new $this->class();
            return $object->hydrate($row);
        } else {
            return null;
        }
    }

    public function findBy(array $params, array $order = null): ?array
    {
        $results = array();

        $sql = "SELECT * FROM $this->table WHERE ";

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

        if($order){
            $sql .= "ORDER BY ". key($order). " ". $order[key($order)];
        }

        $result = $this->connection->query($sql, $params);
        $rows = $result->getArrayResult();

        /*$result = $this->sql($sql, $params);
        $rows = $result->fetchAll();*/

        foreach($rows as $row){
            $object = new $this->class();
            array_push($results, $object->hydrate($row));
        }

        return $results;
    }

    public function findAll(): array
    {

        $sql = "select * from $this->table";

        $result = $this->connection->query($sql);
        $rows = $result->getArrayResult();

        /*$result = $this->sql($sql);
        $rows = $result->fetchAll($this->pdo::FETCH_ASSOC);*/

        $results = array();

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

        $result = $this->connection->query($sql, $params);
        return $result->getValueResult();

        /*$result = $this->sql($sql, $params);
        return $result->fetchColumn();*/
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM $this->table WHERE id = $id";

        $result = $this->connection->query($sql, [':id' => $id]);
        //$result = $this->sql($sql, [':id' => $id]);

        return true;
    }

    protected function sql($sql, $parameters = null)
    {
        if($parameters){
            $queryPrepared = $this->pdo->prepare($sql);
            $queryPrepared->execute($parameters);

            return $queryPrepared;
        } else {
            $queryPrepared = $this->pdo->prepare($sql);
            $queryPrepared->execute();

            return $queryPrepared;
        }
    }
}