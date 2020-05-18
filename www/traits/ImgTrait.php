<?php
namespace App\traits;

Trait ImgTrait
{
    public function getImg(string $path, string $alt): string
    {
        return "<img src='$path' alt='$alt'>";
    }
}