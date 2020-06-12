<?php 
namespace App\core\Connection;

use Throwable;

class PDOResult implements ResultInterface
{
    protected $statement;
  
    public function __construct(\PDOStatement $statement)
    {
        $this->statement = $statement;
    }

    public function getArrayResult(string $class = null): array
    {
        $result = $this->statement->fetchAll(\PDO::FETCH_ASSOC);

        if($class) {
            $results = [];
            foreach($result as $key => $value){
                array_push($results, (new $class())->hydrate($value));
            }
            return $results;
        }
        return $result;
    }

    public function getOneOrNullResult(): ?array
    {
        try {
            return  $this->statement->fetch();
        } catch(Throwable $t) {
            echo $t->getMessage();
        }
        
    }

    public function getValueResult()
    {
        return $this->statement->fetchColumn();
    }
}