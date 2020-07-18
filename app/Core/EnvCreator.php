<?php

namespace App\Core;

class EnvCreator
{
    public static function remove(): void
    {
        if (file_exists(ROOT . '/.env'))
            file_put_contents(ROOT . '/.env', '');
    }

    protected static function arrayKeyToUpper(array $params): array
    {
        $toReturn = [];
        foreach ($params as $key => $value)
            $toReturn[strtoupper($key)] = $value;

        return $toReturn;
    }

    protected static function mapData(array $params): string
    {
        $toReturn = '';
        foreach ($params as $key => $value)
            $toReturn .= $key .  '=' . $value . "\n";

        return $toReturn;
    }

    public static function createOrUpdate(array $params)
    {
        $mapedData = self::mapData(array_merge(
            (new ConstantLoader())->getConstantAsArray(),
            self::arrayKeyToUpper($params)
        ));

        file_put_contents(ROOT . '/.env', $mapedData);

        new ConstantLoader();
    }
}