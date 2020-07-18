<?php
namespace App\Core;
use App\Core\Connection\BDDInterface;
use App\Core\Connection\PDOConnection;
use App\Core\Connection\PDOSingleton;
use App\Core\Constraints\Validator;
use App\Core\Model\Model;

class Manager
{
    private $table;
    private ?PDOConnection $connection;
    protected string $class;

    public function __construct(string $class, string $table, BDDInterface $connection = null)
    {
        $this->class = $class;
        $this->table =  DB_PREFIXE.$table;

        $this->connection = $connection;
        if(NULL === $connection){
            $this->connection = new PDOConnection();
        }
    }

    public function save($objectToSave): string
    {
        $objectArray = $objectToSave->__toArray();

        $columnsData = array_values($objectArray);
        $columns = array_keys($objectArray);

        $params = [];
        foreach($objectArray as $key => $value){
            $params[":$key"] = $value;

            if($value instanceof Model)
                $params[":$key"] = $value->getId();

            if ($value === null || in_array($key, ['created_at', 'updated_at']))
            {
                unset($columns[array_search($key, $columns)]);
                unset($params[":$key"]);
            }
        }

        if (! is_numeric($objectToSave->getId())) {
            $sql = "INSERT INTO ".$this->table." (`".implode("`,`", $columns)."`) VALUES (:".implode(",:", $columns).");";
        } else {
            foreach ($columns as $column) {
                $sqlUpdate[] = "`".$column."`=:".$column;
            }
            $sql = "UPDATE ".$this->table." SET ".implode(",", $sqlUpdate)." WHERE id=:id;";
        }
        
        $this->connection->query($sql, $params);

        return $this->connection->lastInsertId();
    }

    public function find(int $id): ?Model
    {
        $sql = "SELECT * FROM $this->table where id = :id";

        $result = $this->connection->query($sql, [':id' => $id]);
        
        $row = $result->getOneOrNullResult();

        if (! $row)
            return null;

        $object = new $this->class();

        return $object->hydrate($row);
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
            $sql .= " `$key` $comparator :$key and";

            $params[":$key"] = $value;
            unset($params[$key]);
        }

        $sql = rtrim($sql, "and");

        if($order){
            $sql .= "ORDER BY ". key($order). " ". $order[key($order)];
        }

        $result = $this->connection->query($sql, $params);
        $rows = $result->getArrayResult();

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
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM $this->table WHERE id = $id";

        $result = $this->connection->query($sql, [':id' => $id]);

        return true;
    }

    public function create(array $modelProperties): Model
    {
        $class = $this->class;
        $model = (new $class)->hydrate($modelProperties);

        $lastInsertedId = $this->save($model);
        $model->setId($lastInsertedId);

        return $model;
    }
}