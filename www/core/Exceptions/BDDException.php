<?php

namespace App\Core\Exceptions;

use Exception;
class BDDException extends Exception
{
    public function __construct($message, $code = 0)
    {
        parent::__construct($message, $code);
    }

    public function __toString() 
    {
        return $this->message;
    }
}