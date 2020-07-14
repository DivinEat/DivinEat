<?php
namespace App\Managers;

use App\Models\Page;
use App\Core\Manager;

class PageManager extends Manager {
    
    public function __construct(){
        parent::__construct(Page::class, 'pages');
    }
}