<?php

namespace App\Controllers\Admin;

use App\Models\User;
use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\Routing\Router;
use App\Managers\UserManager;
use App\Forms\User\UpdateUserForm;
use App\Core\Controller\Controller;

class UserController extends Controller
{
    public function index(Request $request, Response $response)
    {
        $userManager = new UserManager();
        $users = $userManager->findAll();

        $configTableUser = User::getShowUserTable($users);

        $response->render("admin.user.index", "admin", ["configTableUser" => $configTableUser]);
    }

    public function edit(Request $request, Response $response, array $args)
    {
        $id = $args['user_id'];

        if(isset($id)){
            $userManager = new UserManager();
            $user = $userManager->find($id);
        } else {
            throw new \Exception("L'id de l'utilisateur n'existe pas.");
        }
        
        $form = $response->createForm(UpdateUserForm::class, $user);

        $response->render("admin.user.edit", "admin", ["updateUserForm" => $form]);
    }

    public function update(Request $request, Response $response, array $args)
    {
        $data = $_POST;

        foreach($data as $elementName => $element) {
            $data[explode("_", $elementName)[1]] = $data[$elementName];
            unset($data[$elementName]);
        }

        $response->checkFormData([
            "id" => intval($data["id"]),
            "dateInserted" => $data["dateInserted"],
        ]);
        
        $data["status"] = intval($data["status"]);
        
        $user = (new User())->hydrate($data);
        $user->setPwd(password_hash($user->getPwd(), PASSWORD_DEFAULT));
        
        $form = $response->createForm(UpdateUserForm::class, $user);
        
        if (false === $form->handle()) {
            $response->render("admin.user.edit", "admin", ["updateUserForm" => $form]);
        } else {
            (new UserManager())->save($user);     
            Router::redirect('admin.user.index');
        }
    }

    public function destroy(Request $request, Response $response, array $args)
    {
        $manager = new UserManager();
        $manager->delete($args["user_id"]);

        Router::redirect('admin.user.index');
    }
}