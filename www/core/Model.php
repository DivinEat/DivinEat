<?php

namespace App\Core;

use App\Core\Exceptions\BDDException;
use App\Controllers\ErrorController;
use Exception;

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
            } else {
                throw new BDDException("Le setter n'existe pas.");
            }
        }
        
        return $this;
    }
}