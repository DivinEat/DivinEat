<?php

namespace App\Controllers;

use App\Core\View;
use App\Core\Validator;
use App\Models\User;
use App\Core\Manager;
use App\Managers\UserManager;
use App\Core\QueryBuilder;

class UserController
{
    public function defaultAction()
    {
        $userManager = new UserManager();

        // find
        echo json_encode($userManager->find(1), JSON_PRETTY_PRINT);
        echo '<br>';

        // findBy
        var_dump($userManager->findBy(["firstname" => "Ludo"], ["id" => "desc"]));
        echo '<br>';

        // count
        echo $userManager->count(["firstName" => "Joe"]);
        echo '<br>';

        // findAll
        echo json_encode($userManager->findAll(), JSON_PRETTY_PRINT);
        echo '<br>';

        // delete
        var_dump($userManager->delete(2));
    }

    public function addAction()
    {
        echo "User add";
        $userManager = new UserManager();
        $user = new User();
            
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

        $configFormUser = User::getRegisterForm();

        if($_SERVER["REQUEST_METHOD"] == "POST"){
            //Vérification des champs
            $errors = Validator::checkForm($configFormUser ,$_POST);
            //Insertion ou erreurs
            print_r($errors);

            if (empty($errors)) {
                $data = $_SESSION['register_data'];
                $user = new User();
                
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
        return $firstUser;
    }

    public function testQueryAction()
    {   
        $user = $this->getFirstUserAction();

        var_dump($this->getUserPost(1));
    }
}
