<?php
namespace App\Managers;

use App\Core\Manager;
use App\Models\Article;

class ArticleManager extends Manager {
    
    public function __construct(){
        parent::__construct(Article::class, 'articles');
    }
}