<?php

namespace App\Core;

use App\Core\Migration\MigrationRunner;
use App\Core\Routing\Router;

class Sitemap
{
    public static function generate(): void
    {
        $addedUrls = [];
        $xw = xmlwriter_open_memory();
        xmlwriter_set_indent($xw, 1);
        xmlwriter_set_indent_string($xw, ' ');

        xmlwriter_start_document($xw, '1.0', 'UTF-8');
        xmlwriter_start_element($xw, 'urlset');
        xmlwriter_start_attribute($xw, 'xmlns');
        xmlwriter_text($xw, $_SERVER['HTTP_ORIGIN']. 'sitemap.xml');

        self::generateRoutesLines($xw, $addedUrls, Router::getRouteList());

        xmlwriter_end_element($xw);
        xmlwriter_end_document($xw);

        file_put_contents(ROOT . '/public/sitemap.xml', xmlwriter_output_memory($xw), );
    }

    protected static function generateRoutesLines(&$xw, array &$addedUrls, array $routeList): void
    {
        array_map(function ($route) use ($xw, $addedUrls) {
            if (preg_match('/admin|install/', $route['Name']) || in_array($route['Url'], $addedUrls))
                return;

            if (preg_match('/\{([a-z\_]*)\}/', $route['Url']))
                return self::generateRoutesLinesWithPatern($xw, $addedUrls, $route['Url']);

            self::writeRouteLine($xw, $route['Url']);
            $addeUrls[] = $route['Url'];
        }, $routeList);
    }

    protected static function writeRouteLine(&$xw, $url): void
    {
        xmlwriter_end_attribute($xw);
        xmlwriter_start_element($xw, 'url');
        xmlwriter_start_element($xw, 'loc');
        xmlwriter_write_raw($xw, $url);
        xmlwriter_end_element($xw);
        xmlwriter_end_element($xw);
    }

    protected static function generateRoutesLinesWithPatern(&$xw, array &$addedUrls, string $url): void
    {
        if (! preg_match('/\{([a-z]*)\_([a-z]*)\}/', $url, $match))
            return;
        var_dump($match);die;

    }
}