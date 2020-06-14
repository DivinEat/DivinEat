<?php

namespace App\Controllers\Admin;

use App\Core\Controller\Controller;
use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\Routing\Router;
use App\Core\View;
use App\Models\User;
use App\Managers\UserManager;

class UserController extends Controller
{
    public function index(Request $request, Response $response)
    {
        $userManager = new UserManager();
        $users = $userManager->findAll();

        $configTableUser = User::getShowUserTable($users);

        $myView = new View("admin.user.index", "admin");
        $myView->assign("configTableUser", $configTableUser);
    }

    public function edit(Request $request, Response $response, array $args)
    {
        $id = 2;

        if(isset($id)){
            $userManager = new UserManager();
            $object = $userManager->find($id);
        }

        $configFormUser = User::getEditUserForm($object);

        $myView = new View("admin.user.edit", "admin");
        $myView->assign("configFormUser", $configFormUser);
    }

    public function update(Request $request, Response $response, array $args)
    {
        $data = $_POST;

        $userManager = new UserManager();
        $user = $userManager->find($data["id"]);
        
        $user->setFirstname($data["firstname"]);
        $user->setLastname($data["lastname"]);
        $user->setEmail($data["email"]);
        $user->setStatus($data["status"]);
        $user->setDate_updated(date('Y-m-d H:i:s'));

        $userManager->save($user);

        Router::redirect('admin.userindex');
    }

    public function destroy(Request $request, Response $response, array $args)
    {
        $data = $_POST;

        $manager = new UserManager();
        $manager->delete($data["id"]);

        Router::redirect('admin.userindex');
    }
}