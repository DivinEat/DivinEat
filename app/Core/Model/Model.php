<?php

namespace App\Core\Model;

class Model implements \JsonSerializable
{
    public function __construct() {}

    public function __toArray(): array
    {
        return get_object_vars($this);
    }

    public function hydrate(array $donnees){
        foreach($donnees as $key => $value){
            $method = 'set'.ucfirst(strtolower($key));
        
            if (method_exists($this, $method)){
                $this->$method($value);
            }
        }
        return $this;
    }

    public function jsonSerialize() {
        return $this->__toArray();
    }
}