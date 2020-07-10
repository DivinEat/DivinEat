<?php
namespace App\Core\Connection;
use PDO;

class PDOSingleton extends PDO 
{
    private $PDOInstance;
    private static $instance;

    private function __construct($dsn, $user, $pwd) {
        try {
            $this->PDOInstance = new PDO($dsn, $user, $pwd);
        } catch(PDOException $e) {
            die("Erreur SQL : ".$e->getMessage());
        }
    }

    public static function getInstance() {
        if (!isset(self::$instance)) {
            $dsn = DB_DRIVER.":host=".DB_HOST.";dbname=".DB_NAME.";";
            $user = DB_USER;
            $pwd = DB_PWD;
            self::$instance = new PDOSingleton($dsn, $user, $pwd);
        } 
        return self::$instance;
    }

    public function prepare($statement, $driver_options = array()) {
        return $this->PDOInstance->prepare($statement, $driver_options);
    }

    public function lastInsertId($name = null): string
    {
        return $this->PDOInstance->lastInsertId();
    }
}