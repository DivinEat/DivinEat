<?php

namespace App\models;

class Model {
    
    public function __toArray(): array {
        $property = get_object_vars($this);

        return $property;
    }

    public function hydrate(array $row) {
        $className = get_class($this);
        $articleObj = new $className();
        foreach ($row as $key => $value){
            $method = 'set'.$key;
            if(method_exists($articleObj, $method)){
                $articleObj->$method($value);
            }
        }
        return $articleObj;
    }

}