<?php
namespace App\core;

use App\core\Exceptions\BDDException;

class Model implements \JsonSerializable
{
    public function __construct(){}

    public function __toArray(): array
    {
        return get_object_vars($this);
    }

    public function hydrate(array $row){
        $className = get_class($this);
        $articleObj = new $className();

        foreach($row as $key => $value){
            $method = 'set'.ucfirst(strtolower($key));

            if (method_exists($articleObj, $method)){
                if($relation = $articleObj->getRelation($key)){
                    $tmp = new $relation();
                    $tmp = $tmp->hydrate($row);
                    $tmp->setId($value);
                    $articleObj->$method($tmp);
                } else {
                    $articleObj->$method($value);
                }
                $this->$method($value);
            } else {
                throw new BDDException("Le setter $method n'existe pas.");
        	}
        }
        return $articleObj;
    }

    public function jsonSerialize() {
        return $this->__toArray();
    }

    public function getRelation(string $key): ?string
    {
        $relations = $this->initRelation();

        if(isset($relations[$key])){
            return $this->initRelation()[$key];
        }

        return null;
    }
}