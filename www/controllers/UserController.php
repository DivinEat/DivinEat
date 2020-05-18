<?php
namespace App\controllers;
use App\core\View;
use App\core\Validator;
use App\models\User;
use App\managers\UserManager;
use App\core\Exception\NotFoundException;

class UserController
{
    public function defaultAction()
    {
        echo "User default";
        
        $userManager = new UserManager();

        $user = $userManager->find(1);

        if(!$user){
            throw new NotFoundException("Aucun utilisateur", 404);
        }
        
        var_dump($user);
    }

    public function addAction()
    {
        echo "User add";
    }

    public function removeAction()
    {
        echo "L'utilisateur va être supprimé";
    }

    public function loginAction()
    {
        $myView = new View("login", "account");
    }

    public function jsonAction()
    {
        $userManager = new UserManager();

        $users = $userManager->findAll();
        $firstUser = json_encode($users[0], JSON_PRETTY_PRINT);

        echo $firstUser;
        return $firstUser;
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
