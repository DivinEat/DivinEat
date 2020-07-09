<?php

namespace App\Core\Model;

abstract class Model implements \JsonSerializable
{
    public function __construct() {}

    public function __toArray(): array
    {
        return get_object_vars($this);
    }

    public function hydrate(array $row)
    {
        $className = get_class($this);
        $articleObj = new $className();
        foreach ($row as $key => $value) {
            $method = 'set'.ucFirst($key);
            if (method_exists($articleObj, $method)) {
                if($relation = $articleObj->getRelation($key)) {
                    $tmp = new $relation();
                    preg_match('/.*\\\([a-zA-Z]*)/', get_class($tmp), $modelName);
                    $managerName = 'App\Managers\\' . $modelName[1] . 'Manager';
                    $articleObj->$method((new $managerName)->find($value));
                } else {
                    $articleObj->$method($value);
                }
            }
        }

        return $articleObj;
    }

    public function jsonSerialize()
    {
        return $this->__toArray();
    }

    public function getRelation(string $key): ?string
    {
        $relations = $this->initRelation();

        if(isset($relations[$key]))
            return $this->initRelation()[$key];

        return null;
    }
}