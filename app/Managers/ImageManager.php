<?php
namespace App\Managers;

use App\Core\Manager;
use App\Models\Image;

class ImageManager extends Manager {
    
    public function __construct(){
        parent::__construct(Image::class, 'images');
    }
}