<?php

namespace App\Managers;

use App\Core\Manager;
use App\Models\Comment;

class CommentManager extends Manager
{
    public function __construct(){
        parent::__construct(Comment::class, 'comments');
    }
}