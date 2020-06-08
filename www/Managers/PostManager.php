<?php
namespace App\Managers;

use App\core\DB;
use App\models\Post;
use App\core\QueryBuilder;

class PostManager extends DB {
    
    public function __construct(){
        parent::__construct(Post::class, 'posts');
    }

    public function getUserPost(int $id){
        return (new QueryBuilder())
            ->select('p.*, u.*')
            ->from('tdd_posts', 'p')
            ->join('tdd_users', 'u')
            ->where('p.author = :iduser')
            ->setParameter('iduser', $id)
            ->getQuery()
            ->getArrayResult(Post::class);
    }
}