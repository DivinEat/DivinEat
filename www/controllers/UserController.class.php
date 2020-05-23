<?php

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

    public function removeAction()
    {
        echo "L'utilisateur va être supprimé";
    }




    public function loginAction()
    {
        $configFormUser = users::getLoginForm();

        $myView = new View("login", "account");
        $myView->assign("configFormUser", $configFormUser);
    }

    public function registerAction()
    {

        $configFormUser = users::getRegisterForm();

        if($_SERVER["REQUEST_METHOD"] == "POST"){
            //Vérification des champs
            $errors = Validator::checkForm($configFormUser ,$_POST);
            //Insertion ou erreurs
            print_r($errors);

            if empty($errors){
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
        $configFormUser = users::getPwdForm();

        $myView = new View("forgotpwd", "account");
        $myView->assign("configFormUser", $configFormUser);
    }
}