<?php
namespace App\controllers;
use App\core\View;
use App\core\Validator;
use App\models\users;

namespace App\controllers;
use App\core\View;

class UserController
{
    public function defaultAction()
    {
        echo "User default";
    }

    public function addAction()
    {
        echo "User add";
    }

    public function getAction($params) {
        $userManager = new UserManager();

        $user = $userManager->find($params['id']);
        $users = $userManager->findAll();

        $partialUsers = $userManager->findBy(['firstname' => 'Remi%'], ['id' => 'desc']);

        $count = $userManager->count(['firstname' => 'Remi%']);

        $userManager->delete(5);

        echo "get user";
    }

    public function removeAction()
    {
        echo "L'utilisateur va être supprimé";
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

            if( empty($errors)){
                $data = $_SESSION['register_data'];
                $user = new users();
                
                $user->setId(1);
                $user->setFirstname("Toto");
                $user->setLastname("Skrzypczyk");
                $user->setEmail("Y.Skrzypczyk@GMAIL.com");
                $user->setPwd("Test1234");
                $user->setStatus(0);
                $user->save();
            }
        }


        $myView = new View("register", "account");
        $myView->assign("configFormUser", $configFormUser);
    }

    public function forgotPwdAction()
    {
        $myView = new View("forgotPwd", "account");
    }
}
