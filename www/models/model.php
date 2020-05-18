<?php
namespace App\models;

class Model
{
    public function __toArray(): array
    {
        $property = get_object_vars($this);

        return $property;
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
}