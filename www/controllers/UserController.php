<?php

namespace App\Controllers;

use App\Core\View;
use App\Core\Validator;
use App\Models\users;
use App\Core\Manager;
use App\Managers\UserManager;

class UserController
{
    public function defaultAction()
    {
        $userManager = new UserManager();

        // find
        // $userManager->find(1);

        // findBy
        // var_dump($userManager->findBy(["firstname" => "Ludo"], ["id" => "desc"]));

        // count
        // echo $userManager->count(["firstName" => "Ludo"]);

        // findAll
        // var_dump($userManager->findAll());

        // delete

        // var_dump($userManager->delete(1));

    }

    public function addAction()
    {
        echo "User add";
        $userManager = new UserManager();
        $user = new users();
            
        $user->setId(2);
        $user->setFirstname("Joe");
        $user->setLastname("Skrzypczyk");
        $user->setEmail("Y.Skrzypczyk@GMAIL.com");
        $user->setPwd("Test1234");
        $user->setStatus(0);

        $userManager->save($user);

    }

    public function removeAction($id)
    {
        $userManager = new UserManager();
        echo "L'utilisateur va être supprimé";
        $userManager->delete($id);
    }

    public function loginAction()
    {
        $myView = new View("login", "account");
    }

    public function registerAction()
    {

        $configFormUser = users::getRegisterForm();

        if($_SERVER["REQUEST_METHOD"] == "POST"){
            //Vérification des champs
            $errors = Validator::checkForm($configFormUser ,$_POST);
            //Insertion ou erreurs
            print_r($errors);

            if (empty($errors)) {
                $data = $_SESSION['register_data'];
                $user = new users();
                
                $user->setId(1);
                $user->setFirstname("Toto");
                $user->setLastname("Skrzypczyk");
                $user->setEmail("Y.Skrzypczyk@GMAIL.com");
                $user->setPwd("Test1234");
                $user->setStatus(0);
                $user->save($user);
            }
        }


        $myView = new View("register", "account");
        $myView->assign("configFormUser", $configFormUser);
    }

    public function forgotPwdAction()
    {
        $myView = new View("forgotPwd", "account");
    }

    public function getFirstUserAction()
    {
        $userManager = new UserManager();

        $users = $userManager->findAll();
        $firstUser = json_encode($users[0], JSON_PRETTY_PRINT);

        echo $firstUser;
        return $firstUser;
    }
}
