<?php

namespace App\Controllers;

use App\Models\Post;
use App\Managers\PostManager;

class PostController
{
    public function defaultAction()
    {
        var_dump($this->getUserPostAction(1));
    }

    public function getUserPostAction(int $id): array
    {
        $postManager = new PostManager();
        $post = $postManager->getUserPost(1);
        var_dump($post);
        return $post;
    }
}
