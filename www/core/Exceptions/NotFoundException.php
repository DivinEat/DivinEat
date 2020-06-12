<?php
namespace App\core\Exceptions;
use Exception;

class NotFoundException extends Exception
{
    public function __construct($message, $code = 0){
        parent::__construct($message, 404);
    }
}