<?php

namespace App\Core;

class Model
{
    public function __construct() 
    {

    }

    public function __toArray(): array
    {
        $property = get_object_vars($this);

        return $property;
    }
    
    public function hydrate($array)
    {
        foreach ($array as $key => $value) {
            $setterName = "set" . strtolower(ucfirst($key));

            if (method_exists($this, $setterName)) {
                $this->$setterName($value);
            }
        }
        return $this;
    }
}