<?php

class Autoloader
{
    public static function register(){
        spl_autoload_register(array(__CLASS__, 'autoload'));
    }

    public static function autoload($class){
        $parts = preg_split('#\\\\#', $class);
        $parts[0] = strtolower($parts[0]);
        $className = array_pop($parts);

        $path = implode(DS, $parts);
        $file = $className.'.php';

        $filepath = ROOT.DS.$path.DS.$file;

        require $filepath;
    }
}