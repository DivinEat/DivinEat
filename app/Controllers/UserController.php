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
        $data = $_POST;

        foreach($data as $elementName => $element) {
            $data[explode("_", $elementName)[1]] = $data[$elementName];
            unset($data[$elementName]);
        }

        $response->checkFormData([
            "dateInserted" => $data["dateInserted"],
        ]);
        
        $user = (new UserManager())->find(Auth::getUser()->getId());
        $user->setFirstname($data['firstname']);
        $user->setLastname($data['lastname']);
        $user->setEmail($data['email']);
        
        $form = $response->createForm(UpdateProfileForm::class, $user);

        if(!password_verify($data['currentPwd'], Auth::getUser()->getPwd()))
            $form->addErrors(["currentPwd" => "Le mot de passe actuel ne correspond pas"]);

        if($data['pwd'] != $data['confirmPwd']){
            $form->addErrors(["confirmPwd" => "Les mots de passe ne correspondent pas"]);
        } else {
            $user->setPwd(password_hash($data['pwd'], PASSWORD_DEFAULT));
        }
        
        if (false === $form->handle()) {
            $response->render("profile", "main", ["updateUserForm" => $form]);
        } else {
            (new UserManager())->save($user);       
            Router::redirect('home');
        }
    }
}