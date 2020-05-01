<?php

class Autoloader
{
    public static function register(){
        spl_autoload_register(array(__CLASS__, 'autoload'));
    }

    public static function autoload($class){
        $classPath = str_replace(
            '\\',
            DIRECTORY_SEPARATOR,
            str_replace('App', 'app', ROOT. DIRECTORY_SEPARATOR . $class)
        );

        if (! file_exists($classPath . '.php'))
            die ('Impossible d\'inclure la classe suivante: ' . $class);

        include $classPath . '.php';
    }
}