<?php

namespace App\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Managers\PostManager;
use App\Managers\UserManager;

class PostController
{
    public function defaultAction()
    {
        $postManager = new PostManager(Post::class, 'posts');
        $userManager = new UserManager(User::class, 'users');
        
        // $user = $userManager->find(1);
        
        /* Création d'user */
        // $user = new User();
        // $user->setFirstName('Joe');
        // $user->setLastName('LeJoe');
        // $user->setEmail("adresse@mail.com");
        // $user->setPwd("password");
        // $user->setStatus(0);
        // $userManager->save($user);

        // $user->setFirstName('Rob');
        // $user->setLastName('LeRob');
        // $user->setEmail("adresse@mail.com");
        // $user->setPwd("password");
        // $user->setStatus(0);
        // $userManager->save($user);

        /* save d'un post */
        // $post = new Post();

        // $user = $userManager->findBy(["firstName" => "Rob"])[0];
        // $user = $userManager->findBy(["firstName" => "Joe"])[0];

        // $post->setTitle('Titre du post1 (Rob)');
        // $post->setAuthor($user);
        // $postManager->save($post);
        // $post->setTitle('Titre du post2 (Rob)');
        // $post->setAuthor($user);
        // $postManager->save($post);
        // $post->setTitle('Titre du post3 (Rob)');
        // $post->setAuthor($user);
        // $postManager->save($post);

        /* Récupérer tous les posts */
        // var_dump($postManager->findAll());

        /* Récupérer les Post pour l'utilisateur Rob */

        $user = $userManager->findBy(["firstName" => "Rob"])[0];
        var_dump($this->getUserPostAction($user->getId()));

    }

    public function getUserPostAction(int $id): array
    {        
        $postManager = new PostManager();
        $post = $postManager->getUserPost($id);
        return $post;
    }
}
