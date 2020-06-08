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
        $rows = (new QueryBuilder())
            ->select('p.*, u.*')
            ->from('nfoz_posts', 'p')
            ->join('nfoz_users', 'u')
            ->where('p.user_id = :user_id')
            ->setParameter('user_id', $id)
            ->getQuery()
            ->getArrayResult(Post::class);

        foreach($rows as $row) {
            $object = new $this->class();
            array_push($results, $object->hydrate($row));
        }

        return $results;
    }
}