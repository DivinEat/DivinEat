<?php
namespace App\controllers;

use App\core\View;
use App\core\Controller;
use App\models\User;
use App\Forms\TestType;
use App\Managers\UserManager;


class DefaultController extends Controller
{
    public function defaultAction()
    {
        $myView = new View("dashboard");
    }

    public function testFormAction()
    {
        $user = (new User())->setFirstName('Fadyl');

        $form = $this->createForm(TestType::class, $user);
        $form->
        handle();

        if($form->isSubmit() && $form->isValid())
        {  
            echo "valide";
        }

        $this->render("editprofile", "account", [
            "formProfile" => $form
        ]);
    }
}