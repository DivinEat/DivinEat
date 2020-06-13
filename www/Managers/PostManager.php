<?php

namespace App\Managers;

use App\Core\Manager;
use App\Models\Post;
use App\Core\QueryBuilder;


class PostManager extends Manager
{
    public function __construct()
    {
        parent::__construct(Post::class, 'posts');
    }

    public function getUserPost(int $id){
        $result = (new QueryBuilder())
            ->select('p.*, u.*')
            ->from(DB_PREFIXE.'posts', 'p')
            ->join('inner', DB_PREFIXE.'users', 'u', 'author', 'id')
            ->where('p.author = :author')
            ->setParameter('author', $id)
            ->getQuery()
            ->getArrayResult(Post::class);

        return $result;
    }
}