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
        $myView->assign("configTableMenu", $configTableUser);
    }

    public function edit(Request $request, Response $response, array $args)
    {
        echo "edit";
    }

    public function update(Request $request, Response $response, array $args)
    {
        echo "update";
    }

    public function destroy(Request $request, Response $response, array $args)
    {
        echo "destroy";
    }
}