<?php
namespace App\core;
use App\core\PDOSingleton;

class DB
{
    private $table;
    private $pdo;
    protected $class;

    public function __construct(string $class, string $table)
    {
        $this->class = $class;
        //SINGLETON
        try {
            $this->pdo = PDOSingleton::getInstance();
        } catch (Exception $e) {
            die("Erreur SQL : ".$e->getMessage());
        }

        $this->table =  DB_PREFIXE.get_called_class();
    }

    public function hydrate(array $donnees){
        foreach($donnees as $key => $value){
            $method = 'set'.ucfirst(strtolower($key));
        
            if (method_exists($this, $method)){
                $this->$method($value);
            }
        }
    }

    public function find(int $id): ?\App\models\Model {
        $sql = 'SELECT * FROM $this->table WHERE id = :id';

        $result = $this->sql($sql, [':id' => $id]);

        $row = $result->fetch();

        if($row){
            $object = new $this->class();
            return $object->hydrate($row);
        } else {
            return null;
        }
    }

    public function findAll(): array {

    }

    public function findBy(array $params, array $order = null): ?array {
        $results = array();

        $sql = "SELECT * FROM $this->table where ";

        foreach($params as $key => $value) {
            if(is_string($value))
                $comparator = 'LIKE';
            else
                $comparator = '=';

            $sql .= " $key $comparator :$key and";

            $params[":$key"] = $value;
            unset($params[$key]);
        }

        $sql = rtrim($sql, 'and');

        if($order){
            $sql .= 'ORDER BY '. key($order). " ". $order[$key($order)];
        }

        $result = $this->sql($sql, $params);
        $rows = $resimt->fetchAll();

        foreach($rows as $row) {
            $object = new $this->class();
            array_push($results, $object->hydrate($row));
        }

        return $results;
    }

    public function count(array $params): int {
        $sql = "SELECT COUNT(*) FROM $this->table WHERE ";

        foreach($params as $key => $value){
            if(is_string($value))
                $comparator = 'LIKE';
            else
                $comparator = '=';

            $sql .= " $key $comparator :$key and";

            $params[":key"] =$value;
            unset($params[$key]);
        }

        $sql = rtrim($sql, 'and');

        $result = $this->sql($sql, $params);
        return $result->fetchColumn();
    }

    public function delete(int $id): bool {
        $sql = "DELETE FROM $this->table WHERE id = :id";

        $result = $this->sql($sql, [':id' => $id]);

        return true;
    }

    protected function sql($sql, $parameters = null) {
        if($parameters){
            $queryPrepared = $this->pdo->prepare($sql);
            $queryPrepared->execute($parameters);

            return $queryPrepared;
        }
    }

    // public function save()
    // {
    //     $propChild = get_object_vars($this);
    //     $propDB = get_class_vars(get_class());

    //     $columnsData = array_diff_key($propChild, $propDB);
    //     $columns = array_keys($columnsData);

        
    //     if (!is_numeric($this->id)) {
            
    //         //INSERT
    //         $sql = "INSERT INTO ".$this->table." (".implode(",", $columns).") VALUES (:".implode(",:", $columns).");";
    //     } else {

    //         //UPDATE
    //         foreach ($columns as $column) {
    //             $sqlUpdate[] = $column."=:".$column;
    //         }

    //         $sql = "UPDATE ".$this->table." SET ".implode(",", $sqlUpdate)." WHERE id=:id;";
    //     }

    //     $queryPrepared = $this->pdo->prepare($sql);
    //     $queryPrepared->execute($columnsData);
    // }

    public function save($objectToSave){
        $objectArray = $objectToSave->__toArray();

        $columnsData = array_values($objectArray);
        $columns = array_keys($objectArray);

        $params = array_combine(
            array_map(function($k){ return ':'.$k; }, array_keys($objectArray)),
            $objectArray
        );

        if (!is_numeric($objectToSave->getId())) {
            //INSERT
            $sql = "INSERT INTO ".$this->table." (".implode(",", $columns).") VALUES (:".implode(",:", $columns)."):";
        } else {
            //UPDATE
            foreach($columns as $column){
                $sqlUpdate[] = $column."=:".$column;
            }

            $sql = "UPDATE ".$this->table." SET ".implode(",", $sqlUpdate)." WHERE id=:id";
        }

        $this->sql($sql, $params);
    }
}
