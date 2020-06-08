<?php

namespace App\Core;

use App\Core\Exceptions\BDDException;
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
        $property = get_object_vars($this);

        return $property;
    }
    
    public function hydrate($array)
    {
        foreach ($array as $key => $value) {
            $setterName = "set" . ucfirst(strtolower($key));
            
            if (method_exists($this, $setterName)) {
                if ( in_array($key, array_keys($this->relation)) ) {
                    $class = $this->relation[$key];

                    
                }

                $this->$setterName($value);
            } else {
                throw new BDDException("Le setter <i>". $setterName ."</i> n'existe pas.");
            }
        }
        
        return $this;
    }
}