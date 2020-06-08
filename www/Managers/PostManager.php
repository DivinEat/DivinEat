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
            ->from('nfoz_posts', 'p')
            ->join('nfoz_users', 'u')
            ->where('p.user_id = :user_id')
            ->setParameter('user_id', $id)
            ->getQuery()
            ->getArrayResult(Post::class);

        $object = new $this->class();
        $object->hydrate($result);

        return $object;
    }
}