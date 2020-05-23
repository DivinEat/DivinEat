<?php
namespace App\controllers;
use App\core\View;
use App\core\Validator;
use App\models\User;
use App\Core\Manager;
use App\Managers\UserManager;

namespace App\controllers;
use App\core\View;

class UserController
{
    public function defaultAction()
    {
        echo "User default";
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

    public function jsonAction()
    {
        echo "Json";
    }

    public function getAction($params){
        $userManager = new UserManager();

        $user = $userManager->find($params['id']);

        $users = $userManager->findAll();

        $partialUser = $userManager->findBy(["firstname" => "Thibault"], ["id" => "desc"]);

        $count = $userManager->count(["firstname" => "Thibault"]);

        $userManager->delete(5);

        echo "get user";
    }

    public function registerAction()
    {

        $configFormUser = User::getRegisterForm();

        if($_SERVER["REQUEST_METHOD"] == "POST"){
            //Vérification des champs
            //$errors = Validator::checkForm($configFormUser ,$_POST);
            //Insertion ou erreurs
            //print_r($errors);

            $userManager = new UserManager();

            //if( empty($errors)){
                $data = $_SESSION['register_data'];
                $user = new User();
                
                $user->setFirstname("Thibault");
                $user->setLastname("Dargent");
                $user->setEmail("tdargent1@gmail.com");
                $user->setPwd("Test1234");
                $user->setStatus(0);
                $userManager->save($user);
            //}
        }

        $myView = new View("register", "account");
        $myView->assign("configFormUser", $configFormUser);
    }

    public function forgotPwdAction()
    {
        $myView = new View("forgotPwd", "account");
    }
}
