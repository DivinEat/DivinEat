<?php 
namespace App\core\Connection;

interface ResultInterface 
{
    public function getArrayResult();
    public function getOneOrNullResult();
    public function getValueResult();
}
