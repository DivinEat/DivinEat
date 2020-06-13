<?php

namespace App\Core;

use App\Core\Exceptions\BDDException;
use App\Core\Model;
use JSONSerializable;

class Model implements JSONSerializable
{
    public function __construct() 
    {
    }

    public function jsonSerialize() {
        return $this->__toArray();
    }

    public function __toArray(): array
    {
        $propertyWithObject = get_object_vars($this);
        $propertiesWithoutObject = [];
        foreach ($propertyWithObject as $key => $value) {            
            if (is_object($value))
                $propertiesWithoutObject[$key] = $value->getId();
            else
                $propertiesWithoutObject[$key] = $value;
        }

        return $propertiesWithoutObject;
    }
    
    public function hydrate(array $row)
    {
        foreach ($row as $key => $value) {
            $setterName = "set" . ucfirst(strtolower($key));   
            if (method_exists($this, $setterName)) {
                if ( $relation = $this->getRelation($key) ) {
                    $tmp = new $relation();
                    $tmp = $tmp->hydrate($row);
                    $tmp->setId($value);
                    $this->$setterName($tmp);
                } else {
                    $this->$setterName($value);
                }
            }
        }
        
        return $this;
    }

    public function initRelation(): array {
        return [
           
        ];
    }

    public function getRelation(string $key): ?string
    {     
        $relations = $this->initRelation();

        if(isset($relations[$key]))
            return $relations[$key];
        
        return null;
    }
}