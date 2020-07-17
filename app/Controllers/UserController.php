<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller\Controller;
use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\Routing\Router;
use App\Forms\User\UpdateProfileForm;
use App\Models\User;
use App\Managers\UserManager;

class UserController extends Controller
{
    public function edit(Request $request, Response $response)
    {
        $user = Auth::getUser();

        $form = $response->createForm(UpdateProfileForm::class, $user);

        $response->render("profile", "main", ["updateUserForm" => $form]);
    }

    public function update(Request $request, Response $response, array $args)
    {
        $request->setInputPrefix('udpateProfileForm_');
        
        $user = (new UserManager())->find(Auth::getUser()->getId());
        $user->setFirstname($request->get('firstname'));
        $user->setLastname($request->get('lastname'));
        $user->setEmail($request->get('email'));
        
        $form = $response->createForm(UpdateProfileForm::class, $user);

        if(! empty($request->get('currentPwd'))){
            if(!password_verify($request->get('currentPwd'), Auth::getUser()->getPwd()))
                $form->addErrors(["currentPwd" => "Le mot de passe actuel ne correspond pas"]);

            if(! empty($request->get('pwd')) && ! empty($request->get('confirmPwd'))){
                if($request->get('pwd') != $request->get('confirmPwd')){
                    $form->addErrors(["confirmPwd" => "Les mots de passe ne correspondent pas"]);
                } else {
                    $user->setPwd(password_hash($request->get('pwd'), PASSWORD_DEFAULT));
                }
            } else {
                $form->addErrors(["confirmPwd" => "Nouveau mot de passe manquant"]);
            }
        }
        
        if (false === $form->handle($request)) {
            return $response->render("profile", "main", ["updateUserForm" => $form]);
        }

        (new UserManager())->save($user);  

        return Router::redirect('profile.edit');
    }
}