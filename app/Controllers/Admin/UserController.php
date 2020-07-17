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
        $request->setInputPrefix('updateFormUser_');

        $response->checkFormData([
            "id" => intval($request->get("id")),
            "dateInserted" => $request->get("dateInserted"),
        ]);
        
        $user = (new User)->hydrate([
            'id' => $request->get("id"),
            'firstname' => $request->get("firstname"),
            'lastname' => $request->get("lastname"),
            'email' => $request->get("email"),
            'status' => intval($request->get("status")),
            'role' => $request->get("role"),
        ]);

        if(! empty($request->get("pwd"))){
            $user->setPwd(password_hash($request->get("pwd"), PASSWORD_DEFAULT));
        }
        
        $form = $response->createForm(UpdateUserForm::class, $user);
        
        if (false === $form->handle($request)) {
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